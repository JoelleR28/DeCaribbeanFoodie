<?php
/*
Plugin Name: Daily Challenges
Description: A plugin to add and display daily challenges for the users.
Version: 1.0
Author: Deepthi Valachery
Author URI: N/A
License: GPL2
*/

// // Prevent direct access
// if (!defined('ABSPATH')) {
//     exit;
// }


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
