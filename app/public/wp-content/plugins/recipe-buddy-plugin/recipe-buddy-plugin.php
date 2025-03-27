<?php
/* 
Plugin Name: Recipe Buddy
Description: Save recipes and edit them, receive suggestions based on ingredients inputted by the user. 
Version: 1.0 
Author: Joelle Ramchandar 
Author URI: ----
License: GPL2 
*/

// Prevent direct access to the plugin file
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

function foodie_enqueue_script() {
    // Enqueue the like button script
    wp_enqueue_script('like-button', plugin_dir_url(__FILE__) . 'js/like-button.js', array('jquery'), null, true);

    // Enqueue the save recipe button script
    wp_enqueue_script('save-recipe-button', plugin_dir_url(__FILE__) . 'js/save-recipe-button.js', array('jquery'), null, true);

    // Localize the like button script
    wp_localize_script('like-button', 'like_button_obj', array(
        'ajax_url' => admin_url('admin-ajax.php'),
    ));

    // Localize the save recipe button script
    wp_localize_script('save-recipe-button', 'save_recipe_button_obj', array(
        'ajax_url' => admin_url('admin-ajax.php'),
    ));

    // Enqueue the stylesheet
    wp_enqueue_style('foodie-like-button', plugin_dir_url(__FILE__) . 'css/style.css');
}
add_action('wp_enqueue_scripts', 'foodie_enqueue_script');


// Register the like button shortcode
function foodie_recipe_like_button_shortcode($atts) {
    // Get the current post ID
    $post_id = get_the_ID();
    
    // Get the current like count, or set to 0 if not set
    $like_count = get_post_meta($post_id, '_like_count', true);
    $like_count = $like_count ? $like_count : 0;
    
    // Output the like button and like count
    $output = '<div class="like-button-container">';
    $output .= '<button class="like-button" data-post-id="' . $post_id . '">Like</button>';
    $output .= '<p class="like-count">' . $like_count . ' Likes</p>';
    $output .= '</div>';
    
    return $output;
}
add_shortcode('recipe_like_button', 'foodie_recipe_like_button_shortcode');

// Handle the AJAX request to update the like count
function foodie_handle_like_button_click() {
    if (isset($_POST['post_id'])) {
        $post_id = intval($_POST['post_id']);
        $like_count = get_post_meta($post_id, '_like_count', true);
        $like_count = $like_count ? $like_count : 0;
        $like_count++;

        // Update the like count in the post meta
        update_post_meta($post_id, '_like_count', $like_count);

        // Return the updated like count
        echo $like_count;
    }
    wp_die(); // required for proper AJAX response
}
add_action('wp_ajax_like_button_click', 'foodie_handle_like_button_click');
add_action('wp_ajax_nopriv_like_button_click', 'foodie_handle_like_button_click');

// Register the Save Recipe button shortcode
function foodie_save_recipe_button_shortcode($atts) {
    $post_id = get_the_ID(); // Get the current post ID
    $user_id = get_current_user_id(); // Get the current user ID
    

    // Check if the recipe is already saved by the user
    $saved_recipes = get_user_meta($user_id, '_saved_recipes', true);
    $saved_recipes = $saved_recipes ? $saved_recipes : array();

    // Check if the recipe is already in the saved list
    $is_saved = in_array($post_id, $saved_recipes);
    
    // Output the save button
    if ($user_id) {
        $button_text = $is_saved ? 'Remove from Favorites' : 'Save to Favorites';
        $output = '<div class="save-recipe-button-container">';
        $output .= '<button class="save-recipe-button" data-post-id=" ' . $post_id . '" data-user-id="' . $user_id . '">' . $button_text . '</button>';
        $output .= '</div>';
    } else if ( !current_user_can( 'subscriber' )){
        $output = '<p>Hello Guest, please log in to save recipes to your favorites.</p>';
        }

    return $output;
}
add_shortcode('recipe_save_button', 'foodie_save_recipe_button_shortcode');

// Handle the Save/Remove Recipe button click
function foodie_handle_save_recipe_button_click() {
    if (isset($_POST['post_id']) && isset($_POST['user_id'])) {
        $post_id = intval($_POST['post_id']);
        $user_id = intval($_POST['user_id']);
        
        // Get the current list of saved recipes for the user
        $saved_recipes = get_user_meta($user_id, '_saved_recipes', true);
        $saved_recipes = $saved_recipes ? $saved_recipes : array();
        
        // Toggle the recipe in the saved list
        if (in_array($post_id, $saved_recipes)) {
            // Remove the recipe from favorites
            $saved_recipes = array_diff($saved_recipes, array($post_id));
        } else {
            // Add the recipe to favorites
            $saved_recipes[] = $post_id;
        }

        // Update the user meta with the new saved recipes list
        update_user_meta($user_id, '_saved_recipes', $saved_recipes);

        // Return the new button text
        $button_text = in_array($post_id, $saved_recipes) ? 'Remove from Favorites' : 'Save to Favorites';
        echo $button_text;
    }
    wp_die(); // required for proper AJAX response
}
add_action('wp_ajax_save_recipe_button_click', 'foodie_handle_save_recipe_button_click');
add_action('wp_ajax_nopriv_save_recipe_button_click', 'foodie_handle_save_recipe_button_click');

// Register the shortcode for displaying saved recipes
function foodie_saved_recipes_shortcode() {
    $user_id = get_current_user_id();
    $output = '';
   
    if ($user_id) {
        $saved_recipes = get_user_meta($user_id, '_saved_recipes', true);
        
        if (!empty($saved_recipes)) {
            $args = array(
                'post_type' => 'recipe', // Assuming 'recipe' is the custom post type
                'post__in' => $saved_recipes,
                'posts_per_page' => -1
            );
            
            $saved_recipes_query = new WP_Query($args);
            
            if ($saved_recipes_query->have_posts()) {
                $output .= '<ul>';
                while ($saved_recipes_query->have_posts()) {
                    $saved_recipes_query->the_post();
                    $output .= '<li><a href="' . get_the_permalink() . '">' . get_the_title() . '</a></li>';
                }
                $output .= '</ul>';
            } else {
                $output .= '<p>No saved recipes found.</p>';
            }
        } else {
            $output .= '<p>You have no saved recipes.</p>';
        }
    } else {
        $output .= '<p>Please log in to see your saved recipes.</p>';
    }

    return $output;
}
add_shortcode('recipe_saved_list', 'foodie_saved_recipes_shortcode');

