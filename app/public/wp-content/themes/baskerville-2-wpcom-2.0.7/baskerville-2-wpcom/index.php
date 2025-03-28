<?php
/**
 * This template is used for recipe blog page.
 *
 * @package Baskerville 2
 */

get_header(); ?>

<main class="wrapper section medium-padding clear" role="main">
	<header class="page-header section-inner">
		<?php the_archive_title( '<h1 class="page-title">', '</h1>' ); ?>
		<?php the_archive_description( '<div class="tag-archive-meta">', '</div>' ); ?>
	</header> <!-- /page-title -->

	<main class="section-inner clear" role="main" >
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