<?php

if (!defined('ABSPATH')) {
    exit;
}

function dc_get_rank_title($points) {
    if ($points >= 20) return "Legend 👑";
    if ($points >= 15) return "Hero 🦸‍♂️";
    if ($points >= 10) return "Challenger 🔥";
    if ($points >= 5)  return "Rookie 🌱";
    return "Newbie 🐣";
}

function dc_render_leaderboard($atts) {
    $atts = shortcode_atts(array(
        'type' => 'all_time' // other values can be 'weekly' or 'monthly'
    ), $atts);

    $meta_key = 'user_points';
    if ($atts['type'] == 'weekly') $meta_key = 'weekly_points';
    if ($atts['type'] == 'monthly') $meta_key = 'monthly_points';

    $args = array(
        'meta_key' => $meta_key,
        'orderby' => 'meta_value_num',
        'order' => 'DESC',
        'number' => 10
    );

    $users = get_users($args);
    $current_user_id = get_current_user_id();
    $output = '<div class="dc-leaderboard"><h2>🏆 Leaderboard (' . ucfirst($atts['type']) . ')</h2><ol>';

    $rank = 1;
    foreach ($users as $user) {
        $points = (int) get_user_meta($user->ID, $meta_key, true);
        $rank_title = dc_get_rank_title($points);
        $class = $user->ID == $current_user_id ? ' class="dc-highlight"' : '';

        $output .= "<li{$class}>";
        $output .= get_avatar($user->ID, 40);
        $output .= " <strong>" . esc_html($user->display_name) . "</strong> - ";
        $output .= "{$points} pts - <em>{$rank_title}</em>";
        $output .= "</li>";
        $rank++;
    }
    $output .= '</ol>';

    // Add "Your Rank" info
    $all_users = get_users(array('meta_key' => $meta_key, 'orderby' => 'meta_value_num', 'order' => 'DESC'));
    $your_rank = 1;
    foreach ($all_users as $user) {
        if ($user->ID == $current_user_id) break;
        $your_rank++;
    }

    $your_points = (int) get_user_meta($current_user_id, $meta_key, true);
    $your_title = dc_get_rank_title($your_points);

    $output .= '<div class="dc-your-rank"><h3>👤 You</h3>';
    $output .= "<p>Rank: #{$your_rank} | Points: {$your_points} | Title: <strong>{$your_title}</strong></p>";
    $output .= '</div></div>';

    return $output;
}
add_shortcode('dc_leaderboard', 'dc_render_leaderboard');
