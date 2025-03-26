<?php
function foodie_post_types()
{
  register_post_type('recipe', array(
    'supports' => array('title', 'thumbnail', 'excerpt'),
    'rewrite' => array('slug' => 'recipes'),
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