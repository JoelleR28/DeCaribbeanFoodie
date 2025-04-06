<?php
/**
 * This is the main generic template file of the theme
 *
 * @package Baskerville 2
 */
get_header(); ?>

<div class="wrapper section medium-padding" id="content" style="background-color: rgba(0, 0, 0, 0.5);">

<main class="section-inner clear" role="main">
    <!-- Hero Section -->
    <section class="hero" style=" background-size: cover; background-position: center; padding: 100px 0; color: white; text-align: center;">
        <div class="hero-content">
            <h1 style="font-size: 48px; font-weight: bold; margin-bottom: 20px;">Welcome to DeCaribbeanFoodie</h1>
            <p style="font-size: 24px; margin-bottom: 30px;">Explore delicious Caribbean-inspired recipes and cooking tips!</p>
            <a href="<?php echo site_url('/recipes'); ?>" style="background-color: #e67e22; padding: 12px 30px; border-radius: 5px; color: white; text-decoration: none; font-weight: bold;">Browse Recipes</a>
        </div>
    </section>
	<div style="color: white;">
    <p style="font-size: 28px; font-weight: bold; margin-bottom: 20px">Latest Recipes</p>
</div>

<?php
// Set up a custom query to fetch 'recipe' post type
$args = array(
    'post_type' => 'recipe',  // Only fetch 'recipe' post type
    'posts_per_page' => 3,   // You can change the number of posts to display
);

$recipe_query = new WP_Query( $args ); // Run the custom query

if ( $recipe_query->have_posts() ) : ?>
    
    <?php if ( is_home() && ! is_front_page() ) : ?>
        <header>
            <h1 class="page-title screen-reader-text"><?php single_post_title(); ?></h1>
        </header>
    <?php endif; ?>

    <div class="posts" id="posts">

        <div class="spinner-container">
            <div id="spinner">
                <div class="double-bounce1"></div>
                <div class="double-bounce2"></div>
            </div>
        </div>

        <?php
        // Loop through the recipe posts
        while ( $recipe_query->have_posts() ) : $recipe_query->the_post();
            get_template_part( 'content', get_post_format() );
        endwhile;
        ?>
    </div> <!-- /posts -->

    <!-- More Recipes Link -->
    <div style="color: white;">
        <a href="http://localhost:10028/recipes/" style="text-decoration: none; font-size: 18px; color: #e67e22; font-weight: bold;">More</a>
    </div>

<?php endif; ?>

<!-- Recipe Categories Section -->
<div style="color: white; margin-top: 60px;">
    <h2 style="font-size: 28px; font-weight: bold; margin-bottom: 20px;">Browse by Categories</h2>
</div>

<div class="category-grid" style="
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
    gap: 20px;
    margin-top: 20px;
">
    <?php
    // Fetch all categories
    $categories = get_terms(array(
        'taxonomy' => 'category', 
        'orderby' => 'name', 
        'order' => 'ASC', 
        'hide_empty' => false,
    ));

	if ($categories) : 
        foreach ($categories as $category) : ?>
            <div class="category-item" >
                <?php
                // Display category image if it has one
                $category_image = get_field('category_image', 'category_' . $category->term_id); 
                if ($category_image) : ?>
                    <div class="category-image" style="margin-bottom: 10px;">
                        <img src="<?php echo $category_image; ?>" alt="<?php echo $category->name; ?>" style="width: 80%; height: auto; border-radius: 50%; object-fit: cover;">
                    </div>
                <?php endif; ?>

                <a href="<?php echo get_category_link($category->term_id); ?>" style="color: #333; text-decoration: none;">
                    <h3 style="font-size: 18px;"><?php echo $category->name; ?></h3>
                    <p style="font-size: 14px; color: #777;"><?php echo $category->count; ?> Recipes</p>
                </a>
            </div>
        <?php endforeach;
    else : ?>
        <p style="color:white;">No categories available yet.</p>
    <?php endif; ?>
</div>

<!-- // Style css inline as this is not my plugin, need to properly merge  -->
<!-- Latest Daily Challenges Section -->
<div style="color: white; margin-top: 40px;">
    <h2 style="font-size: 28px; font-weight: bold; margin-bottom: 20px;">Latest Daily Challenges</h2>
</div>

<?php
// Set up a custom query to fetch 'challenge' post type, limiting to 4 posts
$challenge_query = new WP_Query(array(
    'post_type' => 'challenge',
    'posts_per_page' => 4,   // Limit the number of challenges to 4
    'orderby' => 'date',
    'order' => 'DESC',
));

if ( $challenge_query->have_posts() ) : ?>
    <div class="challenge-grid">
        <?php while ( $challenge_query->have_posts() ) : $challenge_query->the_post(); ?>
            <div class="challenge-card" >
                <!-- Challenge Thumbnail -->
                <?php if (has_post_thumbnail()) : ?>
                    <div class="challenge-thumbnail">
                        <?php the_post_thumbnail('medium', ['style' => 'width: 100%; height: auto; object-fit: cover;']); ?>
                    </div>
                <?php endif; ?>

                <!-- Challenge Title -->
                <h3 style="font-size: 20px; font-weight: bold; color: #333; margin-bottom: 10px;">
                    <a href="<?php the_permalink(); ?>" style="color: #333; text-decoration: none; transition: color 0.2s;">
                        <?php the_title(); ?>
                    </a>
                </h3>

                <!-- Challenge Description (Optional) -->
                <?php if (has_excerpt()) : ?>
                    <p style="color: #777; font-size: 16px; line-height: 1.6; margin-bottom: 15px;">
                        <?php echo wp_trim_words(get_the_excerpt(), 15); ?>
                    </p>
                <?php endif; ?>
            </div>
        <?php endwhile; ?>
    </div>

    <div style="color: white;">
        <a href="<?php echo site_url('/challenges'); ?>" style="font-size: 18px; text-decoration: underline; color: #e67e22;">See More Challenges</a>
    </div>

<?php else : ?>
    <p style="color:white;">No challenges available yet.</p>
<?php endif; ?>

<?php
// Reset post data to the main query after custom query loop
wp_reset_postdata();
?>


    <!-- Meal Planner Call to Action -->
    <div style="border-radius: 10px; margin-top: 60px; padding: 30px; background-color: #2c3e50;">
        <div>
            <h2 style="color: white; margin-bottom: 40px; font-size: 28px; font-weight: bold;">Plan Your Meals</h2>
            <p style="color: white; font-size: 20px; margin-bottom: 25px; max-width: 800px;">
                Track your calories in a personalized meal plan with our easy-to-use meal planner.
            </p>
        </div>
        <a href="<?php echo site_url('/meal-planner'); ?>" style="display: inline-block; background-color: #e67e22; color: white; padding: 12px 30px; border-radius: 5px; text-decoration: none; font-weight: bold; font-size: 20px; transition: background-color 0.3s;">Start Planning Your Meals</a>
    </div>

    <?php
    // Reset post data to the main query after custom query loop
    wp_reset_postdata();
    ?>
</main> <!-- /content -->
</div> <!-- /wrapper -->

<?php get_footer(); ?>
