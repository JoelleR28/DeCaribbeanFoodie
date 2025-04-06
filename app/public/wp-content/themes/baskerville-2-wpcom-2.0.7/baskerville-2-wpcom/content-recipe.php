<?php

/**
 * This template is used in the Loop to display recipe content
 *
 * @package Baskerville 2
 */
?>
<?php if (!is_single()) { ?>
	<div class="post-container">
	<?php } ?>

	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

		<?php
		/**
		 * Post Title
		 */
		$before_title = '<header class="post-header"><h1 class="post-title entry-title"><a href="' . esc_url(get_permalink()) . '" rel="bookmark">';
		$after_title = '</a></h1></header>';
		the_title($before_title, $after_title);

		/**
		 * Post Thumbnail
		 */
		if (baskerville_2_has_post_thumbnail()) { ?>
			<div class="featured-media">
				<?php if (!is_single()) { ?>
					<a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php the_title(); ?>">
						<?php the_post_thumbnail('baskerville-2-post-thumbnail'); ?>
					</a>

				<?php 
				} else {

					the_post_thumbnail('baskerville-2-post-image');
				} ?>
			</div> <!-- /featured-media -->
		<?php }

		echo do_shortcode('[recipe_like_button]');
		echo do_shortcode('[recipe_save_button]');

		/**
		 * Post Content / Excerpt
		 */
		?>

		<div class="recipe-ingredients">
			</br> </br>
			<h3 class="recipe-subtitle">Ingredients</h3>
			</br></br>
			<ul class="blog-recipe-list">
				<?php
				// Get the ingredients from ACF
				$ingredients = get_field('recipe_ingredients');

				// Check if ingredients are not empty
				if ($ingredients) {
					// Split the ingredients by new lines (assuming they are entered this way)
					$ingredients_list = explode("\n", $ingredients);

					// Loop through the array and output each ingredient as an <li>

					foreach ($ingredients_list as $ingredients) {
						echo $ingredients;

					}
				}
				?>
			</ul>
		</div>

		<div class="recipe-instructions">
		</br></br></br>
			<h3 class="recipe-subtitle">Instructions</h3>
			<ul class="blog-recipe-list">
				<?php
				// Get the ingredients from ACF

				$instructions = get_field('recipe_instructions');

				// Check if ingredients are not empty
				if ($instructions) {
					// Split the ingredients by new lines (assuming they are entered this way)
					$instructions_list = explode("\n", $instructions);

					// Loop through the array and output each ingredient as an <li>
					foreach ($instructions_list as $instructions) {
						echo $instructions;
					}
				}
				?>
			</ul>

			</br></br>
			<div class = "how-to-guide">
			<h3 class="recipe-subtitle">How To Cooking Guide</h3>
			<?php echo get_field('how_to_cooking_guide') ?>
			</div>

			</br></br>
			<div class = "link">
			<h3 class="recipe-subtitle">Source Link</h3>
			<?php echo get_field('source_link') ?>
			</div>
			</br></br>
		<?php
		/**
		 * Post Meta
		 */
		
		if (is_single()) { ?>

			<footer class="post-meta-container clear">
				<?php baskerville_2_author_bio(); ?>

				<div class="post-meta clear">
					<?php baskerville_2_single_post_meta(); ?>
					<?php the_post_navigation(); ?>
					<?php edit_post_link(
						sprintf(
							esc_html__('%1$s Edit %2$s', 'baskerville-2'),
							'<i class="fa fa-pencil-square-o"></i>',
							the_title('<span class="screen-reader-text">"', '"</span>', false)
						),
						'<span class="edit-link">',
						'</span>'
					); ?>
				</div>
			</footer> <!-- /post-meta-container -->
			<?php comments_template('', true);

		} else {
			baskerville_2_post_meta();
		} ?>

	</article> <!-- /post -->

	<?php if (!is_single()) { ?>
	</div>
<?php } ?>