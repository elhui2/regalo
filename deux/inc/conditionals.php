<?php
/**
 * Conditional functions to check the status of various locations.
 * @package Deux
 * @since 1.0.0
 */

/**
 * helper if in customizer preview
 * @param  string $string
 * @return string
 */
function deux_in_preview( $string = '', $echo = true ) {

  if ( ! is_customize_preview() ) return;

    if ( ! $echo ) {
    	return $string; 
  	}
    
    echo wp_kses_post( $string );

}

/**
 * Output template customize partial refresh if necessary
 * @param  string $before   
 * @param  string $after    
 * @param  string $base
 * @param  string $name     
 * @return string
 */
function deux_partial_refresh_template( $before, $after, $base, $extension = '' ){
  deux_in_preview( $before );

  get_template_part( 'template-parts/' . $base, $extension );

  deux_in_preview( $after );
}

//==============================================================================
// WooCommerce
//==============================================================================

function deux_is_woocommerce_activated() {

	return class_exists( 'WooCommerce' );

}

/**
 * if cart is `zero` or `empty`
 * @return mixed
 */
function deux_is_cart_empty( $attr ) {

	if ( ! deux_is_woocommerce_activated() ) 
		return false;

	return 0 == WC()->cart->get_cart_contents_count() ? $attr : false;

}

/**
 * checks if shop page
 * @return boolean
 */
function deux_is_shop() {

	return ( function_exists( 'is_shop' ) && is_shop() );
} 

function deux_is_product_category() {

	return ( function_exists( 'is_product_category' ) && is_product_category() );
}

function deux_is_product_tag() {

	return ( function_exists( 'is_product_tag' ) && is_product_tag() );
}

function deux_is_cart() {

	return ( function_exists( 'is_cart' ) && is_cart() );
}

function deux_is_checkout() {

	return ( function_exists( 'is_checkout' ) && is_checkout() );
}

function deux_is_account_page() {

	return ( function_exists( 'is_account_page' ) && is_account_page() );
}

function deux_is_wishlist_page() {

	return ( function_exists( 'yith_wcwl_is_wishlist_page' ) && yith_wcwl_is_wishlist_page() ); 
}


/**
 * Helper Function to get metapost from single post or page based on ID.
 *
 * @since  1.1.4
 * @return bool
 */
function deux_get_the_id() {

	if ( is_singular() ) 
	   return get_the_ID();

	if ( is_home() )
		return get_option( 'page_for_posts' );

	if ( deux_is_woocommerce_activated() ) {
	    if ( deux_is_shop() ) {
			return wc_get_page_id( 'shop' );
	    }
	}

	return get_the_ID();
}

/**
 * 3rd party plugin WooCommerce Return and Exchange
 */
function deux_is_rnx_page(){
	
	if ( ! in_array( 'woocommerce-refund-and-exchange/woocommerce-refund-and-exchange.php', apply_filters( 'active_plugins', get_option( 'active_plugins' ) ) ) ) {
			return;
		}

	$rnx_pages =  get_option( 'ced_rnx_pages' );
    
	if ( is_page( $rnx_pages['pages']['ced_exchange_from'] ) ) {
		return true;
	}

	if ( is_page( $rnx_pages['pages']['ced_return_from'] ) ) {
		return true;
	}

	if ( is_page( $rnx_pages['pages']['ced_request_from'] ) ) {
		return true;
	}

	if ( is_page( $rnx_pages['pages']['ced_cancel_request_from'] ) ) {
		return true;
	}
    
    return false;
}