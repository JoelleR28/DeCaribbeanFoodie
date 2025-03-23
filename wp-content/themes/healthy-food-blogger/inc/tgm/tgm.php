<?php
/**
 * Recommended plugins.
 */
	
require get_template_directory() . '/inc/tgm/class-tgm-plugin-activation.php';

function healthy_food_blogger_register_recommended_plugins() {
	$plugins = array(
		array(
			'name'             => __( 'Current Date Shortcode For WordPess', 'healthy-food-blogger' ),
			'slug'             => 'current-date',
			'required'         => false,
			'force_activation' => false,
		),
		array(
			'name'             => __( 'WooCommerce', 'healthy-food-blogger' ),
			'slug'             => 'woocommerce',
			'required'         => false,
			'force_activation' => false,
		)
	);
	$config = array();
	healthy_food_blogger_tgmpa( $plugins, $config );
}
add_action( 'tgmpa_register', 'healthy_food_blogger_register_recommended_plugins' );