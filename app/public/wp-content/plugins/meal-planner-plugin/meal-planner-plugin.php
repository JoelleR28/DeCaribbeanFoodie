<?php
/* 
Plugin Name: Meal Planner
Description: Save recipies or whole foods to a meal plan to manage daily calorie intake 
Version: 1.0 
Author: Terrel Briggs
Author URI: https://github.com/TerrelBriggs
License: GPLv2 
*/

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

// Define plugin constants
define('MPP_PLUGIN_DIR', plugin_dir_path(__FILE__));
define('MPP_PLUGIN_URL', plugin_dir_url(__FILE__));

// Include required files
require_once MPP_PLUGIN_DIR . 'includes/class-meal-planner.php';
require_once MPP_PLUGIN_DIR . 'includes/class-meal-planner-shortcode.php';

// Initialize the plugin
function mpp_init() {
    // Initialize the main plugin class
    $meal_planner = new Meal_Planner();
    $meal_planner->init();
    
    // Initialize the shortcode class
    $shortcode = new Meal_Planner_Shortcode();
    $shortcode->init();
}
add_action('plugins_loaded', 'mpp_init');

// Register the Meal Plan post type
function mpp_register_post_type() {
    register_post_type('meal_plan', array(
        'public' => false,
        'show_ui' => false,
        'show_in_menu' => false,
        'supports' => array('title', 'author'),
        'capability_type' => 'post',
        'capabilities' => array(
            'create_posts' => 'do_not_allow',
            'edit_post' => 'edit_posts',
            'delete_post' => 'delete_posts',
        ),
        'map_meta_cap' => true,
    ));
}
add_action('init', 'mpp_register_post_type');

// Activation hook
register_activation_hook(__FILE__, 'mpp_activate');
function mpp_activate() {
    // Flush rewrite rules
    flush_rewrite_rules();
}

// Deactivation hook
register_deactivation_hook(__FILE__, 'mpp_deactivate');
function mpp_deactivate() {
    // Flush rewrite rules
    flush_rewrite_rules();
}
