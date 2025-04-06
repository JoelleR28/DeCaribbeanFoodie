<?php
/**
 * This is the main generic template file of the theme
 *
 * @package Baskerville 2
 */
get_header(); ?>

<div class="wrapper section medium-padding" id="content">

<main class="section-inner clear" role="main" >
<div style=" color: white;"><p style="font-size: 28px; font-weight: bold; margin-bottom: 20px">Latest Recipes</p></div>
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
			<div style=" color: white;"><a href="http://localhost:10028/recipes/" ><p>More</p></a></div>

	<!-- Latest Challenges Section -->
	<div style=" color: white; margin-top: 40px;"><h2 style="font-size: 28px; font-weight: bold; margin-bottom: 20px">Latest Daily Challenges</h2></div>

	<?php
	$challenge_query = new WP_Query(array(
		'post_type' => 'challenge',
		'posts_per_page' => 3,
		'orderby' => 'date',
		'order' => 'DESC',
	));

	if ( $challenge_query->have_posts() ) : ?>
		<div class="posts" id="challenges">
			<?php while ( $challenge_query->have_posts() ) : $challenge_query->the_post(); ?>
			<div class="challenge-card" style="
				background: #fff; 
				padding: 10px; 
				margin-bottom: 15px; 
				border-radius: 10px; 
				display: flex; 
				align-items: center;
				gap: 15px;
				box-shadow: 0 2px 6px rgba(0,0,0,0.1);
			">
			<?php if (has_post_thumbnail()) : ?>
				<div style="flex-shrink: 0;">
				<?php the_post_thumbnail('thumbnail', ['style' => 'border-radius: 8px; width: 100px; height: auto;']); ?>
				</div>
			<?php endif; ?>

			<div>
				<h3 style="margin: 0;"><a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></h3>
			</div>
			</div>
			<?php endwhile; ?>
		</div>
		<div style=" color: white;"><a href="<?php echo site_url('/challenges'); ?>"><p>More</p></a></div>
	<?php else : ?>
		<p style="color:white;">No challenges available yet.</p>
	<?php endif;

	wp_reset_postdata();
	?>

<!-- Meal Planner Ad -->
	<div style="border-radius: 10px;">
    	<div>
			<div style>
				<h2 style="color: white; margin-bottom: 40px; margin-top: 60px; font-size: 28px; font-weight: bold">Plan Your Meals</h2>
				<p style="color: white; font-size: 20px; margin-bottom: 25px; max-width: 800px;">
					Track your calories in a personalized meal plan with our easy-to-use meal planner.
				</p>
			</div>
            <a href="<?php echo site_url('/meal-planner'); ?>" style="display: inline-block; background-color: #e67e22; color: white; padding: 12px 30px; border-radius: 5px; text-decoration: none; font-weight: bold; font-size: 20px; transition: background-color 0.3s;">Start Planning Your Meals</a>
        </div>
    </div>
<!-- End -->

		<?php else : ?>
			<?php get_template_part( 'content', 'none' ); ?>
		<?php endif; ?>

		<?php
		// Reset post data to the main query after custom query loop
		wp_reset_postdata();
		?>
	
	</main> <!-- /content -->
</div> <!-- /wrapper -->

<?php get_footer(); ?>