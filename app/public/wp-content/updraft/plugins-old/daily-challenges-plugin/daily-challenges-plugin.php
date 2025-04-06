<?php
/*
Plugin Name: Daily Challenges
Description: A plugin to add and display daily challenges for the users.
Version: 1.1
Author: Deepthi Valachery
Author URI: N/A
License: GPL2
*/

require_once plugin_dir_path(__FILE__) . 'includes/leaderboard.php';

function dc_enqueue_styles() {
    wp_enqueue_style('dc-custom-style', plugin_dir_url(__FILE__) . 'assets/css/style.css');
}
add_action('wp_enqueue_scripts', 'dc_enqueue_styles');


// Assign Badge Based on Points
function dc_assign_badge($user_id) {
    $points = intval(get_user_meta($user_id, 'user_points', true));

    $champion = get_option('dc_champion_threshold', 5);
    $master = get_option('dc_master_threshold', 10);

    $badge = "Beginner";
    if ($points >= $master) {
        $badge = "Master";
    } elseif ($points >= $champion) {
        $badge = "Champion";
    }

    update_user_meta($user_id, 'user_badge', $badge);
}

// Display Challenges
function dc_display_challenges() {
    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

    $args = array(
        'post_type' => 'challenge',
        'posts_per_page' => 5,
        'paged' => $paged
    );
    $query = new WP_Query($args);

    if ($query->have_posts()) {
        $output = '<div class="dc-challenge-wrapper">';
        while ($query->have_posts()) {
            $query->the_post();
            $post_id = get_the_ID();
            $user_id = get_current_user_id();
            $completed = get_post_meta($post_id, 'completed_by_' . $user_id, true);

            $output .= '<div class="dc-challenge-card">';
            if (has_post_thumbnail()) {
                $output .= '<div class="dc-challenge-img">' . get_the_post_thumbnail(null, 'medium') . '</div>';
            }
            $output .= '<div class="dc-challenge-content">';
            $output .= '<h2><a href="' . get_permalink() . '">' . get_the_title() . '</a></h2>';
            $output .= '<p>' . get_the_excerpt() . '</p>';
            
            if ($completed) {
                $output .= '<p class="dc-completed">✅ Completed</p>';
            } else {
                $output .= '<form method="post" class="dc-complete-form">
                    <input type="hidden" name="challenge_id" value="' . $post_id . '">
                    <button type="submit" name="complete_challenge" class="dc-btn">Mark as Completed</button>
                </form>';
            }
            
            $user_points = get_user_meta($user_id, 'user_points', true);
            $user_badge = get_user_meta($user_id, 'user_badge', true);
            $output .= '<div class="dc-user-progress">';
            $output .= '<p>🎯 Your Points: ' . ($user_points ? $user_points : 0) . '</p>';
            $output .= '<p>🏆 Your Badge: ' . ($user_badge ? $user_badge : "No Badge Yet") . '</p>';
            $output .= '</div></div></div>';
        }
        $output .= '</div>'; 
        $output .= '<div class="dc-pagination">';
        $output .= paginate_links(array(
            'total' => $query->max_num_pages,
            'current' => $paged,
            'prev_text' => __('« Prev'),
            'next_text' => __('Next »'),
        ));
        $output .= '</div>';
        wp_reset_postdata();
        return $output;
    } else {
        return '<p>No challenges available yet.</p>';
    }
}
add_shortcode('daily_challenges', 'dc_display_challenges');

// Schedule Daily Challenge Upload
function dc_schedule_daily_challenge() {
    if (!wp_next_scheduled('dc_publish_challenge')) {
        wp_schedule_event(time(), 'daily', 'dc_publish_challenge');
    }
}
add_action('wp', 'dc_schedule_daily_challenge');

// Schedule Weekly and Monthly Point Reset
function dc_schedule_reset_events() {
    if (!wp_next_scheduled('dc_reset_weekly_points')) {
        wp_schedule_event(strtotime('next Monday'), 'weekly', 'dc_reset_weekly_points');
    }
    if (!wp_next_scheduled('dc_reset_monthly_points')) {
        wp_schedule_event(strtotime('first day of next month midnight'), 'monthly', 'dc_reset_monthly_points');
    }
}
add_action('wp', 'dc_schedule_reset_events');

// Reset Weekly Points for All Users
function dc_reset_weekly_points() {
    $users = get_users();
    foreach ($users as $user) {
        delete_user_meta($user->ID, 'weekly_points');
    }
}
add_action('dc_reset_weekly_points', 'dc_reset_weekly_points');

// Reset Monthly Points for All Users
function dc_reset_monthly_points() {
    $users = get_users();
    foreach ($users as $user) {
        delete_user_meta($user->ID, 'monthly_points');
    }
}
add_action('dc_reset_monthly_points', 'dc_reset_monthly_points');

// Upload the Oldest Draft Challenge
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

// Mark Challenge as Completed
function dc_mark_challenge_completed() {
    if (isset($_POST['complete_challenge'])) {
        $user_id = get_current_user_id();
        $challenge_id = intval($_POST['challenge_id']);

        if ($user_id && $challenge_id) {
            $already_completed = get_post_meta($challenge_id, 'completed_by_' . $user_id, true);
            
            if (!$already_completed) {
                update_post_meta($challenge_id, 'completed_by_' . $user_id, true);

                // Update Total Points
                $current_points = get_user_meta($user_id, 'user_points', true);
                $new_points = intval($current_points) + 1;
                update_user_meta($user_id, 'user_points', $new_points);

                $weekly_points = get_user_meta($user_id, 'weekly_points', true);
                $monthly_points = get_user_meta($user_id, 'monthly_points', true);

                $new_weekly = intval($weekly_points) + 1;
                $new_monthly = intval($monthly_points) + 1;

                update_user_meta($user_id, 'weekly_points', $new_weekly);
                update_user_meta($user_id, 'monthly_points', $new_monthly);

                // Assign Badge
                dc_assign_badge($user_id);
            }
        }
    }
}
add_action('init', 'dc_mark_challenge_completed');

// Add Admin Settings Page
function dc_add_settings_page() {
    add_options_page(
        'Daily Challenge Settings',
        'Daily Challenge',
        'manage_options',
        'dc-settings',
        'dc_render_settings_page'
    );
}
add_action('admin_menu', 'dc_add_settings_page');

// Register Settings
function dc_register_settings() {
    register_setting('dc-settings-group', 'dc_champion_threshold');
    register_setting('dc-settings-group', 'dc_master_threshold');
}
add_action('admin_init', 'dc_register_settings');

// Render Settings Page
function dc_render_settings_page() {
    ?>
    <div class="wrap">
        <h1>Daily Challenge Settings</h1>
        <form method="post" action="options.php">
            <?php settings_fields('dc-settings-group'); ?>
            <?php do_settings_sections('dc-settings-group'); ?>
            
            <table class="form-table">
                <tr valign="top">
                    <th scope="row">Champion Badge Threshold</th>
                    <td><input type="number" name="dc_champion_threshold" value="<?php echo esc_attr(get_option('dc_champion_threshold', 5)); ?>" /></td>
                </tr>
                <tr valign="top">
                    <th scope="row">Master Badge Threshold</th>
                    <td><input type="number" name="dc_master_threshold" value="<?php echo esc_attr(get_option('dc_master_threshold', 10)); ?>" /></td>
                </tr>
            </table>
            
            <?php submit_button(); ?>
        </form>
    </div>
    <?php
}
