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
        $output = '<div class="challenges-grid">';
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
            $output .= '</div></div>';
        }
        $output .= '</div>';
        wp_reset_postdata();
        return $output;
    } else {
        return '<p>No challenges available yet.</p>';
    }
}
add_shortcode('daily_challenges', 'dc_display_challenges');

// Scedule a daily event
function dc_schedule_daily_challenge() {
    if (!wp_next_scheduled('dc_publish_challenge')) {
        wp_schedule_event(time(), 'daily', 'dc_publish_challenge');
    }
}
add_action('wp', 'dc_schedule_daily_challenge');

// Upload the oldest draft challenge
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

// Tracks a user's completion
function dc_mark_challenge_completed() {
    if (isset($_POST['complete_challenge'])) {
        $user_id = get_current_user_id();
        $challenge_id = intval($_POST['challenge_id']);

        if ($user_id && $challenge_id) {
            update_post_meta($challenge_id, 'completed_by_' . $user_id, true);
        }
    }
}
add_action('init', 'dc_mark_challenge_completed');
