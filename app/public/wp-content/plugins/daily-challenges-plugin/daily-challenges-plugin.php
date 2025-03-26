<?php
/*
Plugin Name: Daily Challenges
Description: A plugin to add and display daily challenges for the users.
Version: 1.0
Author: Deepthi Valachery
Author URI: N/A
License: GPL2
*/

// Register the Challenge Custom Post Type
function dc_register_challenge_cpt() {
    register_post_type('challenge', array(
        'supports' => array('title', 'editor', 'thumbnail', 'excerpt', 'custom-fields'),
        'rewrite' => array('slug' => 'challenges'),
        'has_archive' => true,
        'public' => true,
        'show_in_rest' => true,
        'labels' => array(
            'name' => "Challenges",
            'singular_name' => "Challenge",
            'add_new_item' => 'Add New Challenge',
            'edit_item' => 'Edit Challenge',
            'all_items' => 'All Challenges',
        ),
        'menu_icon' => 'dashicons-awards',
    ));
}
add_action('init', 'dc_register_challenge_cpt');

// Shortcode to Display Challenges
function dc_display_challenges() {
    $args = array('post_type' => 'challenge', 'posts_per_page' => 5);
    $query = new WP_Query($args);

    if ($query->have_posts()) {
        $output = '<ul>';
        while ($query->have_posts()) {
            $query->the_post();
            $output .= '<li><a href="' . get_permalink() . '"><strong>' . get_the_title() . '</strong></a>: ' . get_the_excerpt() . '</li>';
        }
        $output .= '</ul>';
        wp_reset_postdata();
        return $output;
    } else {
        return '<p>No challenges available yet.</p>';
    }
}
add_shortcode('daily_challenges', 'dc_display_challenges');
