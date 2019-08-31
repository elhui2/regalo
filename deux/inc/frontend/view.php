<?php

/**
* 
*/
class Deux_Frontend_View {

	public static function Access() {
		$views = apply_filters( 'deux_get_access_frontend_view', array(
			'page' 		=> is_page(),
			'blog' 		=> is_singular('post'),
			'shop'		=> ( function_exists( 'is_woocommerce' ) && ( is_woocommerce() || is_post_type_archive( 'product' ) ) ),
			'cart' 	   	=> deux_is_cart(),
			'checkout'	=> deux_is_checkout(),
			'account'   => deux_is_account_page(),
			'wishlist' 	=> deux_is_wishlist_page(),
			'rnx'       => deux_is_rnx_page(),
		) );

		foreach ( $views as $view_name => $view_key ) {
			if ( $view_key ) {
				return $view_name;		
			}
		}

		return 'default';
	}

	/**
	 * Returns an array of the available layout types.
	 *
	 * @since  1.1
	 * @access public
	 * @return array
	 */
	public static function layout_types() {

		return array(
			'no-sidebar'   => get_template_directory_uri() . '/assets/images/options/sidebars/empty.png',
			'single-left'  => get_template_directory_uri() . '/assets/images/options/sidebars/single-left.png',
			'single-right' => get_template_directory_uri() . '/assets/images/options/sidebars/single-right.png',
		);
	}
}