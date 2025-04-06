<?php
/* 
Plugin Name: Recipe Buddy
Description: Add recipes to a personal saved recipes collection and edit them, receive recipe suggestions based on ingredients inputted by the user. 
Version: 1.0 
Author: Joelle Ramchandar 
Author URI: N/A
License: GPL2 
*/

// Prevent direct access to the plugin file
if (!defined('ABSPATH')) {
    exit;
}

// Background WP function to load scripts
function recipe_buddy_enqueue_script()
{
    // Enqueue the like button script
    wp_enqueue_script('like-button', plugin_dir_url(__FILE__) . 'js/like-button.js', array('jquery'), null, true);
    // Enqueue the save recipe button script
    wp_enqueue_script('save-recipe-button', plugin_dir_url(__FILE__) . 'js/save-recipe-button.js', array('jquery'), null, true);
    // Enqueue the recipe editor script
    wp_enqueue_script('recipe-editor', plugin_dir_url(__FILE__) . 'js/edit-saved-recipe.js', array('jquery'), null, true);
    // Enqueue the stylesheet
    wp_enqueue_style('foodie-styles', plugin_dir_url(__FILE__) . 'css/style.css');

    // Localize the like button script
    wp_localize_script('like-button', 'like_button_obj', array(
        'ajax_url' => admin_url('admin-ajax.php'),
    ));

    // Localize the save recipe button script
    wp_localize_script('save-recipe-button', 'save_recipe_button_obj', array(
        'ajax_url' => admin_url('admin-ajax.php'),
    ));
    // Localize the recipe editor script to pass the AJAX URL and nonce
    wp_localize_script('recipe-editor', 'recipeEditorParams', array(
        'ajaxurl' => admin_url('admin-ajax.php'),
        'security' => wp_create_nonce('edit_saved_recipe_nonce'), // Pass the nonce here
        'post_type' => 'saved-recipe' // Add the custom post type name
    ));

    // Localize the script to pass ajaxurl to JavaScript
    wp_localize_script('save-recipe-button', 'recipeBuddyAjax', array(
        'ajaxurl' => admin_url('admin-ajax.php'), // Pass admin-ajax.php URL
    ));
}
add_action('wp_enqueue_scripts', 'recipe_buddy_enqueue_script');

// Function to register the like button shortcode
function recipe_buddy_like_button_shortcode($atts)
{
    // Get the current post ID
    $post_id = get_the_ID();

    // Get the current like count, or set to 0 if not set
    $like_count = get_post_meta($post_id, '_like_count', true);
    $like_count = $like_count ? $like_count : 0;

    // Only display the like functionality to a logged in user/subscriber
    if (is_user_logged_in()) {
        // Output the like button and like count
        $output = '<div class="like-button-container">';
        $output .= '<button class="like-button" data-post-id="' . $post_id . '">Like</button>';
        $output .= '<p class="like-count">' . $like_count . ' Likes</p>';
        $output .= '</div>';
    } else
        // If the user is not logged in, display a message to log in
        $output = '<p>Please <a href="' . wp_login_url() . '">log in</a> to like this post.</p>';
    return $output;
}
add_shortcode('recipe_like_button', 'recipe_buddy_like_button_shortcode');

// Functioin to handle the AJAX request to update the like count
function recipe_buddy_handle_like_button_click()
{
    if (isset($_POST['post_id'])) {
        $post_id = intval($_POST['post_id']);
        $like_count = get_post_meta($post_id, '_like_count', true);

        // Ensure like count is initialized if not set
        if (!$like_count) {
            $like_count = 0;
        }

        //If the user is logged in, get their id and whether they liked the current post 
        if (is_user_logged_in()) {
            $user_id = get_current_user_id();
            $liked_posts = get_user_meta($user_id, 'liked_posts', true);

            // If no likes exist, initialize the liked post array
            if (!$liked_posts) {
                $liked_posts = [];
            }

            // If the post hasn't been liked by the user, like it now
            if (!in_array($post_id, $liked_posts)) {
                // Add post ID to the liked posts array list
                $liked_posts[] = $post_id;
                update_user_meta($user_id, 'liked_posts', $liked_posts);

                // Increment the like count
                $like_count++;

                // Update the like count in the post meta
                update_post_meta($post_id, '_like_count', $like_count);
                // Return the updated like count in the success response
                wp_send_json_success(['like_count' => $like_count]);

            } else {
                // Return an error message if the user has already liked the post
                wp_send_json_error(['message' => 'You have already liked this post.']);
            }
        } else {
            // Return an error message if the user is not logged in
            wp_send_json_error(['message' => 'You need to be logged in to like this post.']);
        }
    }
    wp_die(); // required for proper AJAX response
}
add_action('wp_ajax_like_button_click', 'recipe_buddy_handle_like_button_click');
add_action('wp_ajax_nopriv_like_button_click', 'recipe_buddy_handle_like_button_click');


// Function to register the Save Recipe button shortcode 
function recipe_buddy_save_recipe_button_shortcode($atts)
{
    $post_id = get_the_ID(); // store the recipe post id in a variable 
    $user_id = get_current_user_id(); // store the current user id in a variable

    // Check if the recipe is already saved by the user using a custom WP query
    $args = [
        'post_type' => 'saved_recipe', //CPT
        'posts_per_page' => 1, // Only should return 1 in any case
        'post_status' => 'publish', // must be published
        'meta_query' => [
            ['key' => '_original_recipe_id', 'value' => $post_id, 'compare' => '='], //this is the varibale storing the recipe post id, different from saved recipe id
            ['key' => '_saved_by_user', 'value' => $user_id, 'compare' => '=']  // this value tells us whether the recipe was saved or not
        ]
    ];

    //Define the WP Query, passing in the array above with the required information
    $existing_query = new WP_Query($args);
    $is_saved = $existing_query->have_posts();
    wp_reset_postdata();

    // Display the save to favourites button
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
add_shortcode('recipe_save_button', 'recipe_buddy_save_recipe_button_shortcode');

// Function to handle the Save/Remove Recipe button on click (contains complex query)
function recipe_buddy_handle_save_recipe_button_click()
{
    //Check to validate whetehr the user is logged in or not
    if (!isset($_POST['post_id']) || !is_user_logged_in()) {
        wp_send_json_error(['message' => 'Invalid request or not logged in.']);
    }

    $post_id = intval($_POST['post_id']); // Get the post id
    $user_id = get_current_user_id(); // Get the current user id
    $original_ingredients = get_field('recipe_ingredients', $post_id); // Get the ingredients
    $original_instructions = get_field('recipe_instructions', $post_id); // Get the instructions
    $excerpt = get_the_excerpt($post_id); // Get the excerpt of the original recipe
    $thumbnail_id = get_post_thumbnail_id($post_id); // Get the attachment ID of the featured image

    // Check if the recipe is already saved by the user/subscriber by storing an array with the post information needed
    $args = [
        'post_type' => 'saved_recipe', //CPT
        'posts_per_page' => 1, //By default it is always 1
        'post_status' => 'publish', //Status should be published
        'meta_query' => [
            ['key' => '_original_recipe_id', 'value' => $post_id, 'compare' => '='], //this is the varibale storing the recipe post id, different from saved recipe id
            ['key' => '_saved_by_user', 'value' => $user_id, 'compare' => '=']  // this value tells us whether the recipe was saved or not
        ]
    ];

    //Define the WP Query and pass in the array with the post information required
    $existing_query = new WP_Query($args);

    // Check if the recipe is already saved by the user/subscriber through the wp query loop, and allow removal upon user request (button click)
    if ($existing_query->have_posts()) { // This checks if there are any posts in the $existing_query object
        // If there are posts existing, meaning the user has saved this already, they can now remove saved recipe
        while ($existing_query->have_posts()) {
            $existing_query->the_post();
            wp_delete_post(get_the_ID(), true); //Delete saved_recipe post
        }
        wp_reset_postdata();// Update the post data

        wp_send_json_success(['button_text' => 'Save to Favorites']); //reset the button to save to favourites as the post is no longer saved
    } else {
        // The user is requesting to create a new saved recipe post on button click, save to favourites (recipe is not saved yet)
        // Used to set the default WP fields upon post creation
        $new_saved_recipe_id = wp_insert_post([
            'post_type' => 'saved_recipe', //CPT
            'post_title' => get_the_title($post_id), //Set the saved_recipe post title 
            'post_status' => 'publish', //Publish the post status so the user can see it
            'post_author' => $user_id,  //Set post author to the current user automatically
            'post_excerpt' => $excerpt, //Set the saved_recipe post excerpt 
        ]);

        //Once the saved_recipe post was successfully created, add the values to custom fields
        if ($new_saved_recipe_id) {
            // Store the original recipe ID and the user who saved it
            update_post_meta($new_saved_recipe_id, '_original_recipe_id', $post_id);
            update_post_meta($new_saved_recipe_id, '_saved_by_user', $user_id);

            // Set the custom field values from the original recipe to the new saved recipe post
            update_post_meta($new_saved_recipe_id, 'recipe_ingredients', $original_ingredients);
            update_post_meta($new_saved_recipe_id, 'recipe_instructions', $original_instructions);

            // Set the featured image
            set_post_thumbnail($new_saved_recipe_id, $thumbnail_id); // Use the image ID, not the URL

            //update button text to reflect the recipe post has been saved
            wp_send_json_success(['button_text' => 'Remove from Favorites']);
        } else {
            //error handling
            wp_send_json_error(['message' => 'Failed to save recipe.']);
        }
    }
}
add_action('wp_ajax_save_recipe_button_click', 'recipe_buddy_handle_save_recipe_button_click');
add_action('wp_ajax_nopriv_save_recipe_button_click', 'recipe_buddy_handle_save_recipe_button_click');

// Function to register the shortcode for displaying saved recipes
function recipe_buddy_saved_recipes_shortcode() {
    $user_id = get_current_user_id(); // Get the current user id and store it in a variable
    $output = ''; // Declare a string variable 

    // Pagination setup
    $paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

    if ($user_id) {
        // Define array to store post information for the query
        $args = array(
            'post_type' => 'saved_recipe', // Custom Post Type
            'posts_per_page' => 2, // Limits the posts on a page to 2
            'paged' => $paged, // Set the pagination variable
            'post_status' => 'publish', // Only show published posts
            'author' => $user_id, // Filter by current user ID
        );

        // Define the WP Query and pass in the array with the post information required
        $saved_recipes_query = new WP_Query($args);

        // If there are saved recipe posts, output their content in a card format
        if ($saved_recipes_query->have_posts()) {
            $output .= '<div class="saved-recipe-grid">';  // Start the grid container

            while ($saved_recipes_query->have_posts()) {
                $saved_recipes_query->the_post();
                $output .= '<div class="saved-recipe-card">';  // Start each card

                // Check if the recipe has a featured image and display it
                if (has_post_thumbnail()) {
                    $output .= '<div class="saved-recipe-img">';
                    $output .= get_the_post_thumbnail(get_the_ID(), 'medium');  // Featured image
                    $output .= '</div>';
                }

                // Content within the card to display
                $output .= '<div class="saved-recipe-content">';
                $output .= '<h2>' . get_the_title() . '</h2>';  // Title of the recipe
                $output .= '<p>' . get_the_excerpt() . '</p>';  // Short excerpt of the recipe

                // Add button with a link to the recipe
                $output .= '<a href="' . get_permalink() . '" class="btn">View Recipe</a>';
                $output .= '</div>';  // End content

                $output .= '</div>';  // End card
            }

            // Add pagination
            $output .= '<div class="pagination">';
            $total_pages = $saved_recipes_query->max_num_pages;

            // Once there is more than 1 page, display pagination links
            if ($total_pages > 1) {
                $current_page = max(1, get_query_var('paged'));

                // Capture the pagination HTML and append it to output
                $output .= paginate_links(array(
                    'format' => '/page/%#%',
                    'current' => $current_page,
                    'total' => $total_pages,
                    'prev_text' => __('« Previous'),
                    'next_text' => __('Next »'),
                ));
            }
            $output .= '</div>';  // End pagination
            $output .= '</div>';  // End grid container
        } else {
            $output .= '<p>You have no saved recipes.</p>'; // Display message to the user for no saved_recipe posts
        }

        wp_reset_postdata();
    } else {
        $output .= '<p>Please log in to see your saved recipes.</p>'; // Display message to the user if they aren't logged in
    }

    return $output;
}
add_shortcode('recipe_saved_list', 'recipe_buddy_saved_recipes_shortcode');

//Function to allow archives, tags and categories to show recipe cpt(specifying recipe alone avoids saved_recipe from showing up)
function include_cpt_in_all_archives($query)
{
    // Modify the main query
    if (!is_admin() && $query->is_main_query() && (is_date() || is_author() || is_category() || is_tag())) {
        // Modify the query to include the custom post type recipe
        $query->set('post_type', 'recipe');
    }
}
add_action('pre_get_posts', 'include_cpt_in_all_archives');

// Function to handle saved recipe deletion
function recipe_buddy_handle_saved_recipe_deletion()
{
    if (isset($_GET['action']) && $_GET['action'] === 'delete_recipe' && isset($_GET['saved-recipe_id'])) {
        // Get the saved recipe ID from the URL
        $recipe_id = intval($_GET['saved-recipe_id']);

        // Ensure the post exists and is of type 'saved_recipe'
        $post = get_post($recipe_id);
        if ($post && $post->post_type === 'saved_recipe') {
            // Ensure the user is logged in and is the author of the recipe or a subscriber
            if (get_post_field('post_author', $recipe_id) === get_current_user_id() || current_user_can('subscriber')) {
                // Delete the saved recipe permanently
                $deleted = wp_delete_post($recipe_id, true); // true means permanent deletion

                if ($deleted) {
                    // Redirect to a page after deleting
                    wp_redirect(home_url('/saved-recipes'));  
                    exit;
                } else {
                    wp_die('Error deleting saved recipe');
                }
            } else {
                wp_die('You do not have permission to delete this saved recipe.');
            }
        } else {
            wp_die('Saved recipe not found.');
        }
    }
}
add_action('init', 'recipe_buddy_handle_saved_recipe_deletion');

// Function to retrive recipe details
function get_recipe_details_callback()
{
    if (!isset($_GET['security']) || !wp_verify_nonce($_GET['security'], 'edit_saved_recipe_nonce')) {
        wp_send_json_error('Invalid nonce');
        exit;
    }

    if (isset($_GET['recipe_id']) && is_numeric($_GET['recipe_id'])) {
        $recipe_id = intval($_GET['recipe_id']);
        $recipe = get_post($recipe_id); // Get the post object

        if ($recipe && $recipe->post_type === 'saved_recipe') {
            // Fetch custom fields (ingredients and instructions) associated with the recipe
            $ingredients = get_post_meta($recipe_id, 'recipe_ingredients', true);
            $instructions = get_post_meta($recipe_id, 'recipe_instructions', true);

            // Return the recipe details as a JSON response
            wp_send_json_success(array(
                'title' => $recipe->post_title,
                'ingredients' => $ingredients,
                'instructions' => $instructions,
            ));
        } else {
            wp_send_json_error('Recipe not found or invalid post type');
        }
    } else {
        wp_send_json_error('Invalid recipe ID');
    }

    exit;
}
add_action('wp_ajax_get_recipe_details', 'get_recipe_details_callback');
add_action('wp_ajax_nopriv_get_recipe_details', 'get_recipe_details_callback'); // For non-logged-in users

// Function to update saved_recipe details
function update_recipe_callback()
{
    // Verify the nonce
    if (!isset($_POST['security']) || !wp_verify_nonce($_POST['security'], 'edit_saved_recipe_nonce')) {
        wp_send_json_error('Invalid nonce');
        exit;
    }

    // Check if we have the required data
    if (isset($_POST['recipe_id']) && isset($_POST['recipe_title']) && isset($_POST['recipe_ingredients']) && isset($_POST['recipe_instructions'])) {
        $recipe_id = intval($_POST['recipe_id']);
        $title = sanitize_text_field($_POST['recipe_title']);
        // Use wp_kses_post to preserve allowed HTML tags (e.g., <ul>, <li>, <p>, etc.)
        $ingredients = wp_kses_post($_POST['recipe_ingredients']);
        $instructions = wp_kses_post($_POST['recipe_instructions']);

        // Update the post title and custom fields in one go
        $updated = wp_update_post(array(
            'ID' => $recipe_id,
            'post_title' => $title
        ));

        if ($updated) {
            // Update custom fields (ingredients and instructions) immediately after the post update
            update_post_meta($recipe_id, 'recipe_ingredients', $ingredients);
            update_post_meta($recipe_id, 'recipe_instructions', $instructions);

            wp_send_json_success('Recipe updated successfully!');
        } else {
            wp_send_json_error('Failed to update recipe');
        }
    } else {
        wp_send_json_error('Missing required fields');
    }
    exit;
}

// Function to handle recipe-buddy searching, based on an ingredient inputted by the user/subscriber
function handle_recipe_search_ajax()
{
    if (isset($_GET['recipe_search']) && $_GET['recipe_search'] === '1') {
        $search_term = sanitize_text_field($_GET['s']);
        $search_term_lower = strtolower($search_term);

        error_log('Search term: ' . $search_term_lower);

        $args = array(
            'post_type' => 'recipe',
            'posts_per_page' => -1,
            's' => '', // Disable default WP search
        );

        $query = new WP_Query($args);
        $found = false;

        if ($query->have_posts()) {
            while ($query->have_posts()) {
                $query->the_post();

                // Get ingredients (HTML) from custom field
                $ingredients_html = get_post_meta(get_the_ID(), 'recipe_ingredients', true);
                $ingredients_text = strtolower(wp_strip_all_tags($ingredients_html));

                //for debugging puprposes
                error_log("Checking recipe: " . get_the_title());
                error_log("Ingredients (stripped): " . $ingredients_text);

                if (strpos($ingredients_text, $search_term_lower) !== false) {
                    $found = true;
                    echo '<div class="recipe-result">';
                    if (has_post_thumbnail()) {
                        $thumbnail = get_the_post_thumbnail(get_the_ID(), 'medium'); // You can use 'thumbnail', 'medium', or custom size
                        echo '<div class="recipe-thumb">' . $thumbnail . '</div>';
                    }
                    echo '<h3><a href="' . get_permalink() . '">' . get_the_title() . '</a></h3>';
                    echo '<p>' . get_the_excerpt() . '</p>';
                    echo '</div>';
                }
            }
            if (!$found) {
                echo '<p>No recipes found for this ingredient.</p>';
            }
            wp_reset_postdata();
        } else {
            echo '<p>No recipes found.</p>';
        }
    }
    wp_die();
}
add_action('wp_ajax_recipe_search', 'handle_recipe_search_ajax');
add_action('wp_ajax_nopriv_recipe_search', 'handle_recipe_search_ajax');


// Function to display the recipe-buddy searching on the page
function recipe_buddy_shortcode() {
    // Check if the user is logged in
    if (is_user_logged_in()) {
        ob_start();  // Start output buffering

        // HTML display content for recipe buddy search bar
        ?>
        <section id="recipe-buddy">
            <h2>Recipe Buddy</h2>
            <p>Find recipes by entering an ingredient:</p>

            <!-- Search Form -->
            <form id="recipe-search-form" action="/?s=" method="get" class="recipe-search-form">
                <!-- Hidden Input to Identify the Recipe Buddy Search -->
                <input type="hidden" name="recipe_search" value="1">

                <!-- Search Input Field -->
                <input type="text" name="s" id="recipe-search-input" placeholder="Enter an ingredient..." required>

                <!-- Search Button -->
                <button type="submit">Search</button>
            </form>

            <!-- Area to Display Recipe Results (for live search) -->
            <div id="recipe-results"></div>
        </section>
        <?php
        return ob_get_clean(); // Return the buffered content
    } else {
        // Return a message if the user is not logged in
        return '<p>You must be logged in to use the Recipe Buddy feature.</p>';
    }
}
// Register the shortcode for the recipe buddy functionality
add_shortcode('recipe_buddy', 'recipe_buddy_shortcode');
