<?php
/**
 * This template is used for displaying pages.
 *
 * @package Baskerville 2
 */

get_header(); ?>

<div class="wrapper section medium-padding">
	<main class="section-inner clear" role="main">
		<?php
		$theParent = wp_get_post_parent_ID(get_the_ID());
		if ($theParent) { ?>
			<div class="metabox metabox--position-up metabox--with-home-link">
				<p>
					<a class="metabox__blog-home-link" href="<?php echo get_permalink($theParent); ?>">
						<i class="fa fa-home" aria-hidden="true"></i>
						Back to <?php echo get_the_title($theParent); ?>
					</a>
					<span class="metabox__main"><?php echo the_title(); ?></span>
				</p>
			</div>
		<?php }
		?>
		<?php
		$content_class = is_active_sidebar('sidebar-1') ? "fleft" : "center";
		?>
		<?php
		// this returns the pages but doesn't output it. If the pages has a parent or not
		$testArray = get_pages(array(
			'child_of' => get_the_ID()
		));
		if ($theParent or $testArray) { ?>
			<div class="page-links">
				<h2 class="page-links__title">
					<a href="<?php echo get_permalink($theParent); ?>">
						<?php echo get_the_title($theParent); ?>
					</a>
				</h2>
				<ul class="min-list">
					<?php
					if ($theParent) { // if the current page has a parent 
						$findChildrenOf = $theParent;
					} else { //viewing a parent page 
						$findChildrenOf = get_the_ID();
					}
					wp_list_pages(array(
						'title_li' => NULL,
						'child_of' => $findChildrenOf,
					));
					?>
				</ul>
			</div>
		<?php } ?>
		<div class="content clear <?php echo $content_class; // WPCS: XSS OK. ?>" id="content">

			<?php if (have_posts()):
				while (have_posts()):
					the_post(); ?>

					<?php get_template_part('content', 'page'); ?>

				<?php endwhile; else: ?>

				<?php get_template_part('content', 'none'); ?>

			<?php endif; ?>

		</div> <!-- /content -->
		
		<?php get_sidebar(); ?>

	</main> <!-- /section-inner -->
</div> <!-- /wrapper -->

<?php get_footer(); ?>