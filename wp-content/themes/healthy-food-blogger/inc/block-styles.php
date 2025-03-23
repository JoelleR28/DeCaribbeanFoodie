<?php
/**
 * Block Styles
 *
 * @package healthy_food_blogger
 * @since 1.0
 */

if ( function_exists( 'register_block_style' ) ) {
	function healthy_food_blogger_register_block_styles() {

		//Wp Block Padding Zero
		register_block_style(
			'core/group',
			array(
				'name'  => 'healthy-food-blogger-padding-0',
				'label' => esc_html__( 'No Padding', 'healthy-food-blogger' ),
			)
		);

		//Wp Block Post Author Style
		register_block_style(
			'core/post-author',
			array(
				'name'  => 'healthy-food-blogger-post-author-card',
				'label' => esc_html__( 'Theme Style', 'healthy-food-blogger' ),
			)
		);

		//Wp Block Button Style
		register_block_style(
			'core/button',
			array(
				'name'         => 'healthy-food-blogger-button',
				'label'        => esc_html__( 'Plain', 'healthy-food-blogger' ),
			)
		);

		//Post Comments Style
		register_block_style(
			'core/post-comments',
			array(
				'name'         => 'healthy-food-blogger-post-comments',
				'label'        => esc_html__( 'Theme Style', 'healthy-food-blogger' ),
			)
		);

		//Latest Comments Style
		register_block_style(
			'core/latest-comments',
			array(
				'name'         => 'healthy-food-blogger-latest-comments',
				'label'        => esc_html__( 'Theme Style', 'healthy-food-blogger' ),
			)
		);


		//Wp Block Table Style
		register_block_style(
			'core/table',
			array(
				'name'         => 'healthy-food-blogger-wp-table',
				'label'        => esc_html__( 'Theme Style', 'healthy-food-blogger' ),
			)
		);


		//Wp Block Pre Style
		register_block_style(
			'core/preformatted',
			array(
				'name'         => 'healthy-food-blogger-wp-preformatted',
				'label'        => esc_html__( 'Theme Style', 'healthy-food-blogger' ),
			)
		);

		//Wp Block Verse Style
		register_block_style(
			'core/verse',
			array(
				'name'         => 'healthy-food-blogger-wp-verse',
				'label'        => esc_html__( 'Theme Style', 'healthy-food-blogger' ),
			)
		);
	}
	add_action( 'init', 'healthy_food_blogger_register_block_styles' );
}
