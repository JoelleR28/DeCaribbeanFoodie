<?php
/**
 * Healthy Food Blogger functions and definitions
 *
 * @package healthy_food_blogger
 * @since 1.0
 */

if ( ! function_exists( 'healthy_food_blogger_support' ) ) :
	function healthy_food_blogger_support() {

		load_theme_textdomain( 'healthy-food-blogger', get_template_directory() . '/languages' );

		// Add support for block styles.
		add_theme_support( 'wp-block-styles' );

		add_theme_support('woocommerce');

		// Enqueue editor styles.
		add_editor_style(get_stylesheet_directory_uri() . '/assets/css/editor-style.css');

	}
endif;

add_action( 'after_setup_theme', 'healthy_food_blogger_support' );

if ( ! function_exists( 'healthy_food_blogger_styles' ) ) :
	function healthy_food_blogger_styles() {
		// Register theme stylesheet.
		$healthy_food_blogger_theme_version = wp_get_theme()->get( 'Version' );

		$healthy_food_blogger_version_string = is_string( $healthy_food_blogger_theme_version ) ? $healthy_food_blogger_theme_version : false;
		wp_enqueue_style(
			'healthy-food-blogger-style',
			get_template_directory_uri() . '/style.css',
			array(),
			$healthy_food_blogger_version_string
		);

		wp_enqueue_style( 'dashicons' );

		//font-awesome
		wp_enqueue_style( 'fontawesome', get_template_directory_uri() . '/inc/fontawesome/css/all.css'
			, array(), '6.7.0' );

		wp_enqueue_script( 'healthy-food-blogger-custom-script', get_theme_file_uri( '/assets/custom-script.js' ), array( 'jquery' ), true );

		wp_style_add_data( 'healthy-food-blogger-style', 'rtl', 'replace' );
	}
endif;

add_action( 'wp_enqueue_scripts', 'healthy_food_blogger_styles' );

/* Theme Credit link */
define('HEALTHY_FOOD_BLOGGER_BUY_NOW',__('https://www.cretathemes.com/products/food-blogger-wordpress-theme','healthy-food-blogger'));
define('HEALTHY_FOOD_BLOGGER_PRO_DEMO',__('https://pattern.cretathemes.com/healthy-food-blogger/','healthy-food-blogger'));
define('HEALTHY_FOOD_BLOGGER_THEME_DOC',__('https://pattern.cretathemes.com/free-guide/healthy-food-blogger/','healthy-food-blogger'));
define('HEALTHY_FOOD_BLOGGER_PRO_THEME_DOC',__('https://pattern.cretathemes.com/pro-guide/healthy-food-blogger/','healthy-food-blogger'));
define('HEALTHY_FOOD_BLOGGER_SUPPORT',__('https://wordpress.org/support/theme/healthy-food-blogger/','healthy-food-blogger'));
define('HEALTHY_FOOD_BLOGGER_REVIEW',__('https://wordpress.org/support/theme/healthy-food-blogger/reviews/#new-post','healthy-food-blogger'));
define('HEALTHY_FOOD_BLOGGER_PRO_THEME_BUNDLE',__('https://www.cretathemes.com/products/wordpress-theme-bundle','healthy-food-blogger'));
define('HEALTHY_FOOD_BLOGGER_PRO_ALL_THEMES',__('https://www.cretathemes.com/collections/wordpress-block-themes','healthy-food-blogger'));

// Add block patterns
require get_template_directory() . '/inc/block-patterns.php';

// Add block styles
require get_template_directory() . '/inc/block-styles.php';

// Block Filters
require get_template_directory() . '/inc/block-filters.php';

// Svg icons
require get_template_directory() . '/inc/icon-function.php';

// TGM Plugin
require get_template_directory() . '/inc/tgm/tgm.php';

// Customizer
require get_template_directory() . '/inc/customizer.php';

// Get Started.
require get_template_directory() . '/inc/get-started/get-started.php';

// Add Getstart admin notice
function healthy_food_blogger_admin_notice() { 
    global $pagenow;
    $theme_args      = wp_get_theme();
    $meta            = get_option( 'healthy_food_blogger_admin_notice' );
    $name            = $theme_args->__get( 'Name' );
    $current_screen  = get_current_screen();

    if( !$meta ){
	    if( is_network_admin() ){
	        return;
	    }

	    if( ! current_user_can( 'manage_options' ) ){
	        return;
	    } if($current_screen->base != 'appearance_page_healthy-food-blogger-guide-page' ) { ?>

	    <div class="notice notice-success dash-notice">
	        <h1><?php esc_html_e('Hey, Thank you for installing Healthy Food Blogger Theme!', 'healthy-food-blogger'); ?></h1>
	        <p><a class="button button-primary customize load-customize hide-if-no-customize get-start-btn" href="<?php echo esc_url( admin_url( 'themes.php?page=healthy-food-blogger-guide-page' ) ); ?>"><?php esc_html_e('Navigate Getstart', 'healthy-food-blogger'); ?></a> 
	        	<a class="button button-primary site-edit" href="<?php echo esc_url( admin_url( 'site-editor.php' ) ); ?>"><?php esc_html_e('Site Editor', 'healthy-food-blogger'); ?></a> 
				<a class="button button-primary buy-now-btn" href="<?php echo esc_url( HEALTHY_FOOD_BLOGGER_BUY_NOW ); ?>" target="_blank"><?php esc_html_e('Buy Pro', 'healthy-food-blogger'); ?></a>
				<a class="button button-primary bundle-btn" href="<?php echo esc_url( HEALTHY_FOOD_BLOGGER_PRO_THEME_BUNDLE ); ?>" target="_blank"><?php esc_html_e('Get Bundle', 'healthy-food-blogger'); ?></a>
	        </p>
	        <p class="dismiss-link"><strong><a href="?healthy_food_blogger_admin_notice=1"><?php esc_html_e( 'Dismiss', 'healthy-food-blogger' ); ?></a></strong></p>
	    </div>
	    <?php

	}?>
	    <?php

	}
}

add_action( 'admin_notices', 'healthy_food_blogger_admin_notice' );

if( ! function_exists( 'healthy_food_blogger_update_admin_notice' ) ) :
/**
 * Updating admin notice on dismiss
*/
function healthy_food_blogger_update_admin_notice(){
    if ( isset( $_GET['healthy_food_blogger_admin_notice'] ) && $_GET['healthy_food_blogger_admin_notice'] = '1' ) {
        update_option( 'healthy_food_blogger_admin_notice', true );
    }
}
endif;
add_action( 'admin_init', 'healthy_food_blogger_update_admin_notice' );

//After Switch theme function
add_action('after_switch_theme', 'healthy_food_blogger_getstart_setup_options');
function healthy_food_blogger_getstart_setup_options () {
    update_option('healthy_food_blogger_admin_notice', FALSE );
}