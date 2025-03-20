<?php
/**
 * Block Filters
 *
 * @package healthy_food_blogger
 * @since 1.0
 */

function healthy_food_blogger_block_wrapper( $healthy_food_blogger_block_content, $healthy_food_blogger_block ) {

	if ( 'core/button' === $healthy_food_blogger_block['blockName'] ) {
		
		if( isset( $healthy_food_blogger_block['attrs']['className'] ) && strpos( $healthy_food_blogger_block['attrs']['className'], 'has-arrow' ) ) {
			$healthy_food_blogger_block_content = str_replace( '</a>', healthy_food_blogger_get_svg( array( 'icon' => esc_attr( 'caret-circle-right' ) ) ) . '</a>', $healthy_food_blogger_block_content );
			return $healthy_food_blogger_block_content;
		}
	}

	if( ! is_single() ) {
	
		if ( 'core/post-terms'  === $healthy_food_blogger_block['blockName'] ) {
			if( 'post_tag' === $healthy_food_blogger_block['attrs']['term'] ) {
				$healthy_food_blogger_block_content = str_replace( '<div class="taxonomy-post_tag wp-block-post-terms">', '<div class="taxonomy-post_tag wp-block-post-terms flex">' . healthy_food_blogger_get_svg( array( 'icon' => esc_attr( 'tags' ) ) ), $healthy_food_blogger_block_content );
			}

			if( 'category' ===  $healthy_food_blogger_block['attrs']['term'] ) {
				$healthy_food_blogger_block_content = str_replace( '<div class="taxonomy-category wp-block-post-terms">', '<div class="taxonomy-category wp-block-post-terms flex">' . healthy_food_blogger_get_svg( array( 'icon' => esc_attr( 'category' ) ) ), $healthy_food_blogger_block_content );
			}
			return $healthy_food_blogger_block_content;
		}
		if ( 'core/post-date' === $healthy_food_blogger_block['blockName'] ) {
			$healthy_food_blogger_block_content = str_replace( '<div class="wp-block-post-date">', '<div class="wp-block-post-date flex">' . healthy_food_blogger_get_svg( array( 'icon' => esc_attr( 'calendar' ) ) ), $healthy_food_blogger_block_content );
			return $healthy_food_blogger_block_content;
		}
		if ( 'core/post-author' === $healthy_food_blogger_block['blockName'] ) {
			$healthy_food_blogger_block_content = str_replace( '<div class="wp-block-post-author">', '<div class="wp-block-post-author flex">' . healthy_food_blogger_get_svg( array( 'icon' => esc_attr( 'user' ) ) ), $healthy_food_blogger_block_content );
			return $healthy_food_blogger_block_content;
		}
	}
	if( is_single() ){

		// Add chevron icon to the navigations
		if ( 'core/post-navigation-link' === $healthy_food_blogger_block['blockName'] ) {
			if( isset( $healthy_food_blogger_block['attrs']['type'] ) && 'previous' === $healthy_food_blogger_block['attrs']['type'] ) {
				$healthy_food_blogger_block_content = str_replace( '<span class="post-navigation-link__label">', '<span class="post-navigation-link__label">' . healthy_food_blogger_get_svg( array( 'icon' => esc_attr( 'prev' ) ) ), $healthy_food_blogger_block_content );
			}
			else {
				$healthy_food_blogger_block_content = str_replace( '<span class="post-navigation-link__label">Next Post', '<span class="post-navigation-link__label">Next Post' . healthy_food_blogger_get_svg( array( 'icon' => esc_attr( 'next' ) ) ), $healthy_food_blogger_block_content );
			}
			return $healthy_food_blogger_block_content;
		}
		if ( 'core/post-date' === $healthy_food_blogger_block['blockName'] ) {
            $healthy_food_blogger_block_content = str_replace( '<div class="wp-block-post-date">', '<div class="wp-block-post-date flex">' . healthy_food_blogger_get_svg( array( 'icon' => 'calendar' ) ), $healthy_food_blogger_block_content );
            return $healthy_food_blogger_block_content;
        }
		if ( 'core/post-author' === $healthy_food_blogger_block['blockName'] ) {
            $healthy_food_blogger_block_content = str_replace( '<div class="wp-block-post-author">', '<div class="wp-block-post-author flex">' . healthy_food_blogger_get_svg( array( 'icon' => 'user' ) ), $healthy_food_blogger_block_content );
            return $healthy_food_blogger_block_content;
        }

	}
    return $healthy_food_blogger_block_content;
}
	
add_filter( 'render_block', 'healthy_food_blogger_block_wrapper', 10, 2 );
