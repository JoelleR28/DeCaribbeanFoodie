<?php

if (!defined('ABSPATH')) {
    exit;
}


function dc_display_leaderboard() {
    global $wpdb;
    $table_name = $wpdb->prefix . "usermeta";

    // Get users with the highest completed challenges
    $query = "
        SELECT user_id, COUNT(meta_value) as completed_count
        FROM $table_name
        WHERE meta_key LIKE 'completed_by_%'
        GROUP BY user_id
        ORDER BY completed_count DESC
        LIMIT 10
    ";
    $results = $wpdb->get_results($query);

    if (!$results) {
        return '<p>No leaderboard data available.</p>';
    }

    $output = '<div class="dc-plugin-container leaderboard"><h2>🏆 Leaderboard 🏆</h2><ol>';
    foreach ($results as $row) {
        $user = get_userdata($row->user_id);
        $output .= "<li>{$user->display_name} - {$row->completed_count} Challenges Completed</li>";
    }
    $output .= '</ol></div>';

    return $output;
}

add_shortcode('dc_leaderboard', 'dc_display_leaderboard');
?>
