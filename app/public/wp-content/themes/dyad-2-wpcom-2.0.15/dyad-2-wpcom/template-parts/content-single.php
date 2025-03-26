<?php declare( strict_types = 1 ); ?>
<?php
/**
 * Template part for displaying single posts.
 *
 * @package Dyad
 */

?>

<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php if ( dyad_2_has_post_thumbnail() && 'image' != get_post_format() ) : ?>
		<?php
		$thumb = dyad_2_get_attachment_image_src( $post->ID, the_post_thumbnail( $post->ID ), 'dyad-2-featured-image' );
		?>

<div class="entry-media" style="background-image: url(<?php echo esc_url( $thumb ); ?>)">
		</div><!-- .entry-media -->
	<?php endif; ?>


	<div class="entry-inner">

		<header class="entry-header">
			<div class="entry-meta">
				<?php dyad_2_entry_meta(); ?>
			</div><!-- .entry-meta -->

			<?php the_title( '<h1 class="entry-title">', '</h1>' ); ?>

			<div class="entry-posted">
				<?php dyad_2_posted_on(); ?>
			</div><!-- .entry-posted -->
		</header><!-- .entry-header -->

		<div class="entry-content">
			<?php the_content(); ?>
			<?php
				wp_link_pages( array(
					'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'dyad-2' ),
					'after'  => '</div>',
				) );
			?>
		</div><!-- .entry-content -->

		<?php dyad_2_post_footer(); ?>

		<?php dyad_2_author_bio(); ?>
	</div><!-- .entry-inner -->
</article><!-- #post-## -->

