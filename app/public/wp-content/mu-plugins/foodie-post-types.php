<?php
function foodie_post_types(){ 
        register_post_type('recipe',array( 
                'supports' => array('title', 'thumbnail', 'excerpt'),
                'rewrite'=> array('slug' => 'recipes'), 
                'has_archive' => true, 
                'public' => true,  
                'show_in_rest' => true,
                'labels' => array( 
                'name' => "Recipes",
                'singular_name' => "Recipe",    
                'add_new_item' => 'Add New Recipe',
                'edit_item' => 'Edit Recipe',
                'all_items' => 'All Recipes',
              ),
                'menu_icon' => 'dashicons-food',
         )); 
     } 
    add_action('init', 'foodie_post_types'); 
    
?>