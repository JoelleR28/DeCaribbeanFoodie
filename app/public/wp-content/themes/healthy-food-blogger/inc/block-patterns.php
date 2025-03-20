<?php
/**
 * Block Patterns
 *
 * @package healthy_food_blogger
 * @since 1.0
 */

function healthy_food_blogger_register_block_patterns() {
	$healthy_food_blogger_block_pattern_categories = array(
		'healthy-food-blogger' => array( 'label' => esc_html__( 'Healthy Food Blogger', 'healthy-food-blogger' ) ),
		'pages' => array( 'label' => esc_html__( 'Pages', 'healthy-food-blogger' ) ),
	);

	$healthy_food_blogger_block_pattern_categories = apply_filters( 'healthy_food_blogger_healthy_food_blogger_block_pattern_categories', $healthy_food_blogger_block_pattern_categories );

	foreach ( $healthy_food_blogger_block_pattern_categories as $name => $properties ) {
		if ( ! WP_Block_Pattern_Categories_Registry::get_instance()->is_registered( $name ) ) {
			register_block_pattern_category( $name, $properties );
		}
	}
}
add_action( 'init', 'healthy_food_blogger_register_block_patterns', 9 );