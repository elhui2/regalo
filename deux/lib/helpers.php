<?php

/**
 * Helper function for getting the script/style `.min` suffix for minified files.
 *
 * @since  1.0.0
 * @access public
 * @return string
 */
function deux_get_min_suffix() {
  return defined( 'WP_DEBUG' ) && true === WP_DEBUG ? '' : '.min';
}

/**
 * if tag shortcode exists
 * @param  string $tags 
 * @return string
 */
function deux_shortcode_tag_exists( $tag, $atts = array(), $content = null ){
  global $shortcode_tags;

  if ( shortcode_exists( $tag ) ) {

	  if ( ! isset( $shortcode_tags[ $tag ] ) ) {
		return false;
	  }

    return call_user_func( $shortcode_tags[ $tag ], $atts, $content, $tag );
  }

}