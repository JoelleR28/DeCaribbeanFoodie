<?php
function foodie_post_types(){ 
        register_post_type('recipe',array( 
                'supports' => array('title', 'thumbnail', 'excerpt'),
                'rewrite'=> array('slug' => 'recipes'), 
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
         
         register_post_type('Games',array( 
          'supports' => array('title', 'thumbnail', 'excerpt'),
          'rewrite'=> array('slug' => 'recipes'), 
          'has_archive' => true, 
          'public' => true,  
          'labels' => array( 
          'name' => "Games",
          'singular_name' => "Recipe",    
          'add_new_item' => 'Add New Recipe',
          'edit_item' => 'Edit Recipe',
          'all_items' => 'All Recipes',
        ),
          'menu_icon' => 'dashicons-food',
   )); 
   
      register_post_type('Food',array(
        'public' => true,
        'labels' => array('name' => "Food", 'add_new_item' => 'Add New Food Item'),
        'menu_icon' => 'dashicons-carrot'
        )); 

      register_post_type('Meal Plan',array(
        'public' => true,
        'labels' => array('name' => "Food", 'add_new_item' => 'Add New Food Item'),
        'menu_icon' => 'dashicons-carrot'
        )); 
}
        add_action('init', 'foodie_post_types'); 
    
?>