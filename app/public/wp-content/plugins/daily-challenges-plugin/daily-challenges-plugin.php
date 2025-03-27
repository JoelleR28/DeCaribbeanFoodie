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

function dc_schedule_daily_challenge() {
    if (!wp_next_scheduled('dc_publish_challenge')) {
        wp_schedule_event(time(), 'daily', 'dc_publish_challenge');
    }
}
add_action('wp', 'dc_schedule_daily_challenge');

function dc_publish_daily_challenge() {
    $args = array(
        'post_type' => 'challenge',
        'post_status' => 'draft',
        'orderby' => 'date',
        'order' => 'ASC',
        'posts_per_page' => 1
    );

    $query = new WP_Query($args);

    if ($query->have_posts()) {
        $query->the_post();
        $post_id = get_the_ID();

        wp_update_post(array(
            'ID' => $post_id,
            'post_status' => 'publish'
        ));
    }
}
add_action('dc_publish_challenge', 'dc_publish_daily_challenge');
