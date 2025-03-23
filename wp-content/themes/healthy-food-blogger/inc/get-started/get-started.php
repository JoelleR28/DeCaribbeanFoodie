<?php
add_action( 'admin_menu', 'healthy_food_blogger_getting_started' );
function healthy_food_blogger_getting_started() {
	add_theme_page( esc_html__('Get Started', 'healthy-food-blogger'), esc_html__('Get Started', 'healthy-food-blogger'), 'edit_theme_options', 'healthy-food-blogger-guide-page', 'healthy_food_blogger_test_guide');
}

// Add a Custom CSS file to WP Admin Area
function healthy_food_blogger_admin_theme_style() {
   wp_enqueue_style('custom-admin-style', esc_url(get_template_directory_uri()) . '/inc/get-started/get-started.css');
}
add_action('admin_enqueue_scripts', 'healthy_food_blogger_admin_theme_style');

//guidline for about theme
function healthy_food_blogger_test_guide() { 
	//custom function about theme customizer
	$return = add_query_arg( array()) ;
	$theme = wp_get_theme( 'healthy-food-blogger' );
?>
	<div class="wrapper-outer">
		<div class="left-main-box">
			<div class="intro"><h3><?php echo esc_html( $theme->Name ); ?></h3></div>
			<div class="left-inner">
				<div class="about-wrapper">
					<div class="col-left">
						<p><?php echo esc_html( $theme->get( 'Description' ) ); ?></p>
					</div>
					<div class="col-right">
						<img role="img" src="<?php echo esc_url(get_template_directory_uri()); ?>/inc/get-started/images/screenshot.png" alt="" />
					</div>
				</div>
				<div class="link-wrapper">
					<h4><?php esc_html_e('Important Links', 'healthy-food-blogger'); ?></h4>
					<div class="link-buttons">
						<a href="<?php echo esc_url( HEALTHY_FOOD_BLOGGER_THEME_DOC ); ?>" target="_blank"><?php esc_html_e('Free Setup Guide', 'healthy-food-blogger'); ?></a>
						<a href="<?php echo esc_url( HEALTHY_FOOD_BLOGGER_SUPPORT ); ?>" target="_blank"><?php esc_html_e('Support Forum', 'healthy-food-blogger'); ?></a>
						<a href="<?php echo esc_url( HEALTHY_FOOD_BLOGGER_PRO_DEMO ); ?>" target="_blank"><?php esc_html_e('Live Demo', 'healthy-food-blogger'); ?></a>
						<a href="<?php echo esc_url( HEALTHY_FOOD_BLOGGER_PRO_THEME_DOC ); ?>" target="_blank"><?php esc_html_e('Pro Setup Guide', 'healthy-food-blogger'); ?></a>
					</div>
				</div>
				<div class="support-wrapper">
					<div class="editor-box">
						<i class="dashicons dashicons-admin-appearance"></i>
						<h4><?php esc_html_e('Theme Customization', 'healthy-food-blogger'); ?></h4>
						<p><?php esc_html_e('Effortlessly modify & maintain your site using editor.', 'healthy-food-blogger'); ?></p>
						<div class="support-button">
							<a class="button button-primary" href="<?php echo esc_url( admin_url( 'site-editor.php' ) ); ?>" target="_blank"><?php esc_html_e('Site Editor', 'healthy-food-blogger'); ?></a>
						</div>
					</div>
					<div class="support-box">
						<i class="dashicons dashicons-microphone"></i>
						<h4><?php esc_html_e('Need Support?', 'healthy-food-blogger'); ?></h4>
						<p><?php esc_html_e('Go to our support forum to help you in case of queries.', 'healthy-food-blogger'); ?></p>
						<div class="support-button">
							<a class="button button-primary" href="<?php echo esc_url( HEALTHY_FOOD_BLOGGER_SUPPORT ); ?>" target="_blank"><?php esc_html_e('Get Support', 'healthy-food-blogger'); ?></a>
						</div>
					</div>
					<div class="review-box">
						<i class="dashicons dashicons-star-filled"></i>
						<h4><?php esc_html_e('Leave Us A Review', 'healthy-food-blogger'); ?></h4>
						<p><?php esc_html_e('Are you enjoying Our Theme? We would Love to hear your Feedback.', 'healthy-food-blogger'); ?></p>
						<div class="support-button">
							<a class="button button-primary" href="<?php echo esc_url( HEALTHY_FOOD_BLOGGER_REVIEW ); ?>" target="_blank"><?php esc_html_e('Rate Us', 'healthy-food-blogger'); ?></a>
						</div>
					</div>
				</div>
			</div>
			<div class="go-premium-box">
				<h4><?php esc_html_e('Why Go For Premium?', 'healthy-food-blogger'); ?></h4>
				<ul class="pro-list">
					<li><?php esc_html_e('Advanced Customization Options', 'healthy-food-blogger');?></li>
					<li><?php esc_html_e('One-Click Demo Import', 'healthy-food-blogger');?></li>
					<li><?php esc_html_e('WooCommerce Integration & Enhanced Features', 'healthy-food-blogger');?></li>
					<li><?php esc_html_e('Performance Optimization & SEO-Ready', 'healthy-food-blogger');?></li>
					<li><?php esc_html_e('Premium Support & Regular Updates', 'healthy-food-blogger');?></li>
				</ul>
			</div>
		</div>
		<div class="right-main-box">
			<div class="right-inner">
				<div class="pro-boxes">
					<h4><?php esc_html_e('Get Theme Bundle', 'healthy-food-blogger'); ?></h4>
					<img role="img" src="<?php echo esc_url(get_template_directory_uri()); ?>/inc/get-started/images/bundle.png" alt="bundle image" />
					<p><?php esc_html_e('SUMMER SALE: ', 'healthy-food-blogger'); ?><strong><?php esc_html_e('Extra 20%', 'healthy-food-blogger'); ?></strong><?php esc_html_e(' OFF on WordPress Theme Bundle Use Code: ', 'healthy-food-blogger'); ?><strong><?php esc_html_e('“HEAT20”', 'healthy-food-blogger'); ?></strong></p>
					<a href="<?php echo esc_url( HEALTHY_FOOD_BLOGGER_PRO_THEME_BUNDLE ); ?>" target="_blank"><?php esc_html_e('Get Theme Bundle For ', 'healthy-food-blogger'); ?><span><?php esc_html_e('$86', 'healthy-food-blogger'); ?></span><?php esc_html_e(' $68', 'healthy-food-blogger'); ?></a>
				</div>
				<div class="pro-boxes">
					<h4><?php esc_html_e('Healthy Food Blogger Pro', 'healthy-food-blogger'); ?></h4>
					<img role="img" src="<?php echo esc_url(get_template_directory_uri()); ?>/inc/get-started/images/premium.png" alt="premium image" />
					<p><?php esc_html_e('SUMMER SALE: ', 'healthy-food-blogger'); ?><strong><?php esc_html_e('Extra 25%', 'healthy-food-blogger'); ?></strong><?php esc_html_e(' OFF on WordPress Block Themes! Use Code: ', 'healthy-food-blogger'); ?><strong><?php esc_html_e('“SUMMER25”', 'healthy-food-blogger'); ?></strong></p>
					<a href="<?php echo esc_url( HEALTHY_FOOD_BLOGGER_BUY_NOW ); ?>" target="_blank"><?php esc_html_e('Upgrade To Pro', 'healthy-food-blogger'); ?></a>
				</div>
				<div class="pro-boxes last-pro-box">
					<h4><?php esc_html_e('View All Our Themes', 'healthy-food-blogger'); ?></h4>
					<img role="img" src="<?php echo esc_url(get_template_directory_uri()); ?>/inc/get-started/images/all-themes.png" alt="all themes image" />
					<a href="<?php echo esc_url( HEALTHY_FOOD_BLOGGER_PRO_ALL_THEMES ); ?>" target="_blank"><?php esc_html_e('View All Our Premium Themes', 'healthy-food-blogger'); ?></a>
				</div>
			</div>
		</div>
	</div>
<?php } ?>