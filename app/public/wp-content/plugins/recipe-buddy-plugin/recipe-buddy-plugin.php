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
if (!defined('ABSPATH')) {
    exit;
}

function foodie_enqueue_script()
{
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
function foodie_recipe_like_button_shortcode($atts)
{
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
function foodie_handle_like_button_click()
{
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
function foodie_save_recipe_button_shortcode($atts)
{
    $post_id = get_the_ID();
    $user_id = get_current_user_id();

    // Check if the recipe is already saved by the user using a custom post query
    $args = [
        'post_type' => 'saved_recipe',
        'posts_per_page' => 1,
        'post_status' => 'publish',
        'meta_query' => [
            ['key' => '_original_recipe_id', 'value' => $post_id, 'compare' => '='],
            ['key' => '_saved_by_user', 'value' => $user_id, 'compare' => '=']
        ]
    ];

    $existing_query = new WP_Query($args);
    $is_saved = $existing_query->have_posts();
    wp_reset_postdata();

    // Output the save button
    if ($user_id) {
        $button_text = $is_saved ? 'Remove from Favorites' : 'Save to Favorites';
        $output = '<div class="save-recipe-button-container">';
        $output .= '<button class="save-recipe-button" data-post-id="' . $post_id . '" data-user-id="' . $user_id . '">' . $button_text . '</button>';
        $output .= '</div>';
    } else {
        $output = '<p>Hello Guest, please log in to save recipes to your favorites.</p>';
    }

    return $output;
}
add_shortcode('recipe_save_button', 'foodie_save_recipe_button_shortcode');

// Handle the Save/Remove Recipe button click
function foodie_handle_save_recipe_button_click()
{
    if (!isset($_POST['post_id']) || !is_user_logged_in()) {
        wp_send_json_error(['message' => 'Invalid request or not logged in.']);
    }

    $post_id = intval($_POST['post_id']);
    $user_id = get_current_user_id();
    $original_ingredients = get_field('recipe_ingredients', $post_id); 
    $original_instructions = get_field('recipe_instructions', $post_id); 
    $excerpt = get_the_excerpt($post_id); // Get the excerpt of the original recipe
    $thumbnail_id = get_post_thumbnail_id($post_id); // Get the attachment ID of the featured image
    
    
    // Check if the recipe is already saved
    $args = [
        'post_type' => 'saved_recipe',
        'posts_per_page' => 1,
        'post_status' => 'publish',
        'meta_query' => [
            ['key' => '_original_recipe_id', 'value' => $post_id, 'compare' => '='],
            ['key' => '_saved_by_user', 'value' => $user_id, 'compare' => '=']
        ]
    ];

    $existing_query = new WP_Query($args);

    if ($existing_query->have_posts()) {
        // Remove saved recipe
        while ($existing_query->have_posts()) {
            $existing_query->the_post();
            wp_delete_post(get_the_ID(), true);
        }
        wp_reset_postdata();

        wp_send_json_success(['button_text' => 'Save to Favorites']);
    } else {
        // Create a new saved recipe post
        $new_saved_recipe_id = wp_insert_post([
            'post_type' => 'saved_recipe',
            'post_title' => get_the_title($post_id),
            'post_status' => 'publish',
            'post_author' => $user_id,
            'post_excerpt' => $excerpt,
        ]);

        
        if ($new_saved_recipe_id) {
            // Store the original recipe ID and the user who saved it
            update_post_meta($new_saved_recipe_id, '_original_recipe_id', $post_id);
            update_post_meta($new_saved_recipe_id, '_saved_by_user', $user_id);

            // Set the custom fields from the original recipe to the new saved recipe post
            update_post_meta($new_saved_recipe_id, 'recipe_ingredients', $original_ingredients);
            update_post_meta($new_saved_recipe_id, 'recipe_instructions', $original_instructions);
            
            // Set the excerpt and featured image
            set_post_thumbnail($new_saved_recipe_id, $thumbnail_id); // Use the image ID, not the URL
           
            wp_send_json_success(['button_text' => 'Remove from Favorites']);
        } else {
            wp_send_json_error(['message' => 'Failed to save recipe.']);
        }
    }
}
add_action('wp_ajax_save_recipe_button_click', 'foodie_handle_save_recipe_button_click');
add_action('wp_ajax_nopriv_save_recipe_button_click', 'foodie_handle_save_recipe_button_click');

// Register the shortcode for displaying saved recipes
function foodie_saved_recipes_shortcode()
{
    $user_id = get_current_user_id();
    $output = '';

    if ($user_id) {
        $args = array(
            'post_type' => 'saved_recipe',
            'posts_per_page' => -1,
            'post_status' => 'publish',
            'author' => $user_id,
        );

        $saved_recipes_query = new WP_Query($args);

        if ($saved_recipes_query->have_posts()) {
            $output .= '<ul>';
            while ($saved_recipes_query->have_posts()) {
                $saved_recipes_query->the_post();
                $output .= '<li><a href="' . get_permalink() . '">' . get_the_title() . '</a>' . '</br>' . get_the_excerpt() . '</li>';
            }
            $output .= '</ul>';
        } else {
            $output .= '<p>You have no saved recipes.</p>';
        }
        wp_reset_postdata();
    } else {
        $output .= '<p>Please log in to see your saved recipes.</p>';
    }

    return $output;
}
add_shortcode('recipe_saved_list', 'foodie_saved_recipes_shortcode');
