<?php
/**
<<<<<<< HEAD
 * This is the main generic template file of the theme
 *
 * @package Baskerville 2
 */
get_header(); ?>

<div class="wrapper section medium-padding clear">

	<main class="content section-inner" id="content" role="main">
		<?php if ( have_posts() ) :

			if ( is_home() && ! is_front_page() ) : ?>
				<header>
					<h1 class="page-title screen-reader-text"><?php single_post_title(); ?></h1>
				</header>

			<?php
			endif; ?>
=======
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

>>>>>>> 2f7f059909147a3aac29f23f9cd7fc3773ec2d06
			<div class="posts" id="posts">

				<div class="spinner-container">
					<div id="spinner">
						<div class="double-bounce1"></div>
						<div class="double-bounce2"></div>
					</div>
				</div>

<<<<<<< HEAD
				<?php while ( have_posts() ) : the_post();
					get_template_part( 'content', get_post_format() );
				endwhile; ?>
			</div> <!-- /posts -->
			<?php the_posts_navigation(); ?>
			<?php else :
				get_template_part( 'content', 'none' );
			?>
		<?php endif; ?>

	</main> <!-- /content -->
</div> <!-- /wrapper -->

<?php get_footer(); ?>
=======
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
>>>>>>> 2f7f059909147a3aac29f23f9cd7fc3773ec2d06
