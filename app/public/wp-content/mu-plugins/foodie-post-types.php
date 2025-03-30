<?php
function foodie_post_types()
{
  register_post_type('recipe', array(

    'capability_type' => 'recipe', 
    'map_meta_cap'=> true,
    'supports' => array('title', 'thumbnail', 'excerpt', 'comments'),
    'taxonomies' => array('category', 'post_tag'), 
    'rewrite' => array('slug' => 'recipes'),
    'show_ui' => true,  // Ensure the UI is available in the admin
    'show_in_rest' => true,  // Enable for Gutenberg editor
    'has_archive' => true,
    'public' => true,
    'labels' => array(
      'name' => "Recipes",
      'singular_name' => "Recipe",
      'add_new_item' => 'Add New Recipe', 
      'edit_item' => 'Edit Recipe',
      'all_items' => 'All Recipes',
    ),
    'menu_icon' => 'dashicons-food',
  ));

  
  register_post_type('saved_recipe', array(
    'capability_type' => 'saved_recipe', 
    'map_meta_cap'=> true,
    'supports' => array('title', 'thumbnail', 'excerpt'),
    'taxonomies' => array('category', 'post_tag'), 
    'rewrite' => array('slug' => 'saved_recipes'),
    'show_ui' => true,  
    'show_in_rest' => true, 
    'public' => true,
    'labels' => array(
      'name' => "Saved Recipes",
      'singular_name' => "Saved Recipe",
      'add_new_item' => 'Add New Saved Recipe', 
      'edit_item' => 'Edit Saved Recipe',
      'all_items' => 'All Saved Recipes',
    ),
    'menu_icon' => 'dashicons-star-filled',
  ));

  // Register the Challenge Custom Post Type
    register_post_type('challenge', array(
      'supports' => array('title', 'editor', 'thumbnail', 'excerpt', 'custom-fields'),
      'rewrite' => array('slug' => 'challenges'),
      'has_archive' => true,
      'public' => true,
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

add_action('init', 'foodie_post_types');
?>