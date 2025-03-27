<?php
/*
Plugin Name: Daily Challenges
Description: A plugin to add and display daily challenges for the users.
Version: 1.0
Author: Deepthi Valachery
Author URI: N/A
License: GPL2
*/

// Shortcode to Display Challenges
function dc_display_challenges() {
    $args = array(
        'post_type' => 'challenge',
        'posts_per_page' => 5
    );
    $query = new WP_Query($args);

    if ($query->have_posts()) {
        $output = '<div class="challenges-grid">'; // Start card container
        while ($query->have_posts()) {
            $query->the_post();
            $output .= '<div class="challenge-card">';
            if (has_post_thumbnail()) {
                $output .= '<div class="challenge-img">' . get_the_post_thumbnail(null, 'medium') . '</div>';
            }
            $output .= '<div class="challenge-content">';
            $output .= '<h2><a href="' . get_permalink() . '">' . get_the_title() . '</a></h2>';
            $output .= '<p>' . get_the_excerpt() . '</p>';
            $output .= '<a href="' . get_permalink() . '" class="btn">View Challenge</a>';
            $output .= '</div></div>'; // Close challenge-card
        }
        $output .= '</div>'; // Close challenges-grid
        wp_reset_postdata();
        return $output;
    } else {
        return '<p>No challenges available yet.</p>';
    }
}
add_shortcode('daily_challenges', 'dc_display_challenges');
