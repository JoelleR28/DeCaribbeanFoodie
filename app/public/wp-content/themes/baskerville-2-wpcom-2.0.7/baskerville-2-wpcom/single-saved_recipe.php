<?php
/**
 * This template is used for displaying single recipe posts.
 *
 * @package Baskerville 2
 */

 
 if (!is_user_logged_in()) {
	 wp_redirect(esc_url(site_url('/')));
	 exit;   
 }
get_header();
?>

<div class="wrapper section medium-padding">
	<main class="section-inner clear" role="main">

		<?php
		$content_class = is_active_sidebar('sidebar-1') ? "fleft" : "center";
		?>
		<div class="content clear <?php echo $content_class; // WPCS: XSS OK. ?>" id="content">

			<?php
			if (have_posts()):
				while (have_posts()):
					the_post();

					get_template_part('content-saved-recipe', get_post_format());
				endwhile;
			else:
				get_template_part('content-saved-recipe', 'none');
			endif;
			?>

		</div> <!-- /content -->

		<?php get_sidebar(); ?>

	</main> <!-- /section-inner -->
</div> <!-- /wrapper -->

<?php get_footer(); ?>