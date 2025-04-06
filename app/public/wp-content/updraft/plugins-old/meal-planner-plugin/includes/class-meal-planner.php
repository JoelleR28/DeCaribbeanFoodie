<?php
if (!defined('ABSPATH')) {
    exit;
}

class Meal_Planner {
    public function init() {
        add_action('wp_enqueue_scripts', array($this, 'enqueue_scripts'));
        add_action('wp_ajax_create_meal_plan', array($this, 'ajax_create_meal_plan'));
        add_action('wp_ajax_add_recipe_to_plan', array($this, 'ajax_add_recipe_to_plan'));
        add_action('wp_ajax_reset_meal_plan', array($this, 'ajax_reset_meal_plan'));
    }
    
    public function enqueue_scripts() {
        wp_enqueue_style('meal-planner-style', MPP_PLUGIN_URL . 'assets/css/meal-planner.css', array(), '1.0.0');
        wp_enqueue_script('meal-planner-script', MPP_PLUGIN_URL . 'assets/js/meal-planner.js', array('jquery'), '1.0.0', true);
        
        wp_localize_script('meal-planner-script', 'mealPlannerAjax', array(
            'ajaxurl' => admin_url('admin-ajax.php'),
            'nonce' => wp_create_nonce('meal-planner-nonce')
        ));
    }
    
    public function get_user_meal_plan($user_id) {
        $args = array(
            'post_type' => 'meal_plan',
            'author' => $user_id,
            'posts_per_page' => 1
        );
        
        $query = new WP_Query($args);
        
        if ($query->have_posts()) {
            return $query->posts[0];
        }
        
        return $this->create_meal_plan($user_id);
    }
    
    public function create_meal_plan($user_id) {
        $post_data = array(
            'post_title' => 'Meal Plan for User ' . $user_id,
            'post_type' => 'meal_plan',
            'post_status' => 'publish',
            'post_author' => $user_id
        );
        
        $post_id = wp_insert_post($post_data);
        
        if ($post_id) {
            // Initialize empty recipe slots
            for ($i = 1; $i <= 5; $i++) {
                update_post_meta($post_id, 'recipe_slot_' . $i, '');
            }
        }
        
        return get_post($post_id);
    }
    
    public function get_meal_plan_items($meal_plan_id) {
        $items = array();
        $total_calories = 0;
        
        for ($i = 1; $i <= 5; $i++) {
            $recipe_id = get_post_meta($meal_plan_id, 'recipe_slot_' . $i, true);
            if ($recipe_id) {
                $recipe = get_post($recipe_id);
                $recipe_calories = get_post_meta($recipe_id, 'recipe_calories', true);
                $serving_size = get_post_meta($recipe_id, 'serving_size', true);
                
                // Calculate calories per serving
                $calories_per_serving = 0;
                if (!empty($recipe_calories) && !empty($serving_size) && $serving_size > 0) {
                    $calories_per_serving = round($recipe_calories / $serving_size);
                }
                
                $total_calories += $calories_per_serving;
                
                $items[$i] = array(
                    'recipe' => $recipe,
                    'calories_per_serving' => $calories_per_serving
                );
            }
        }
        
        $items['total_calories'] = $total_calories;
        return $items;
    }
    
    public function add_recipe_to_plan($meal_plan_id, $recipe_id, $slot_number) {
        return update_post_meta($meal_plan_id, 'recipe_slot_' . $slot_number, $recipe_id);
    }
    
    public function reset_meal_plan($meal_plan_id) {
        for ($i = 1; $i <= 5; $i++) {
            delete_post_meta($meal_plan_id, 'recipe_slot_' . $i);
        }
        return true;
    }
    
    // AJAX handlers
    public function ajax_create_meal_plan() {
        check_ajax_referer('meal-planner-nonce', 'nonce');
        
        if (!is_user_logged_in()) {
            wp_send_json_error('User not logged in');
        }
        
        $meal_plan = $this->create_meal_plan(get_current_user_id());
        wp_send_json_success($meal_plan);
    }
    
    public function ajax_add_recipe_to_plan() {
        check_ajax_referer('meal-planner-nonce', 'nonce');
        
        if (!is_user_logged_in()) {
            wp_send_json_error('User not logged in');
        }
        
        $meal_plan_id = intval($_POST['meal_plan_id']);
        $recipe_id = intval($_POST['recipe_id']);
        $slot_number = intval($_POST['slot_number']);
        
        $result = $this->add_recipe_to_plan($meal_plan_id, $recipe_id, $slot_number);
        
        if ($result) {
            wp_send_json_success('Recipe added successfully');
        } else {
            wp_send_json_error('Failed to add recipe');
        }
    }
    
    public function ajax_reset_meal_plan() {
        check_ajax_referer('meal-planner-nonce', 'nonce');
        
        if (!is_user_logged_in()) {
            wp_send_json_error('User not logged in');
        }
        
        $meal_plan_id = intval($_POST['meal_plan_id']);
        $result = $this->reset_meal_plan($meal_plan_id);
        
        if ($result) {
            wp_send_json_success('Meal plan reset successfully');
        } else {
            wp_send_json_error('Failed to reset meal plan');
        }
    }
} 