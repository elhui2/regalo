<?php

/**
 * Display site header
 */
function deux_header() {
	deux_partial_refresh_template( '<div class="el-customize-header">', '</div>', 'header', deux_get_option( 'header_layout' ) );
}

add_action( 'deux_header', 'deux_header' );

/**
 * Display topbar
 */
function deux_topbar() {
	deux_partial_refresh_template( '<div class="el-customize-topbar">', '</div>', 'topbar' );
}

add_action( 'deux_header_before', 'deux_topbar' );

/**
 * Display page header
 */
function deux_page_header() {
	if ( ! deux_has_page_header() ) {
		return;
	}

	get_template_part( 'template-parts/page-header' );
}

add_action( 'deux_header_after', 'deux_page_header' );

/**
 * Add section if fixed footer to header
 */
function deux_header_fixed_footer() {
	if ( deux_get_option( 'footer_fixed' ) ){
		echo '<div class="content-fixed-footer">';
	}
}

add_action( 'deux_header_before', 'deux_header_fixed_footer' );

/**
 * Display a special page header for WooCommerce pages
 */
function deux_woocommerce_pages_header() {
	if ( ! deux_is_woocommerce_activated() ) {
		return;
	}

	$allow = is_cart() || is_account_page() || deux_is_order_tracking_page() || deux_is_wishlist_page();

	if ( ! $allow ) {
		return;
	}

	$pages = array();

	// Prepare for cart links
	$pages['cart'] = sprintf(
		'<li class="shopping-cart-link line-hover %s"><a href="%s">%s<span class="count cart-counter">%d</span></a></li>',
		is_cart() ? 'active' : '',
		esc_url( wc_get_cart_url() ),
		esc_html__( 'Carrito', 'deux' ),
		WC()->cart->get_cart_contents_count()
	);

	// Prepare for wishlist link
	// if ( function_exists( 'yith_wcwl_count_products' ) ) {
	// 	$wishlist_page_id = yith_wcwl_object_id( get_option( 'yith_wcwl_wishlist_page_id' ) );

	// 	$pages['wishlist'] = sprintf(
	// 		'<li class="wishlist-link line-hover %s"><a href="%s">%s<span class="count wishlist-counter">%d</span></a></li>',
	// 		yith_wcwl_is_wishlist_page() ? 'active' : '',
	// 		esc_url( get_permalink( $wishlist_page_id ) ),
	// 		esc_html__( 'Wishlist', 'deux' ),
	// 		yith_wcwl_count_products()
	// 	);
	// }

	// // Prepare for order tracking link
	// if ( $tracking_page_id = get_option( 'deux_order_tracking_page_id' ) ) {
	// 	$pages['order_tracking'] = sprintf(
	// 		'<li class="order-tracking-link line-hover %s"><a href="%s">%s</a></li>',
	// 		deux_is_order_tracking_page() ? 'active' : '',
	// 		esc_url( get_permalink( deux_get_translated_object_id( $tracking_page_id ) ) ),
	// 		esc_html__( 'Order Tracking', 'deux' )
	// 	);
	// }

	// // Prepare for account link
	// if ( is_user_logged_in() ) {
	// 	$pages['account'] = sprintf(
	// 		'<li class="account-link line-hover %s"><a href="%s">%s</a></li>',
	// 		is_account_page() ? 'active' : '',
	// 		esc_url( wc_get_page_permalink( 'myaccount' ) ),
	// 		esc_html__( 'My Account', 'deux' )
	// 	);
	// }

	// // Prepare for login/logout link
	// if ( is_user_logged_in() ) {
	// 	$pages['logout'] = sprintf(
	// 		'<li class="logout-link line-hover"><a href="%s">%s</a></li>',
	// 		esc_url( wc_get_account_endpoint_url( 'customer-logout' ) ),
	// 		esc_html__( 'Logout', 'deux' )
	// 	);
	// } else {
	// 	$pages['login'] = sprintf(
	// 		'<li class="login-link line-hover %s"><a href="%s">%s</a></li>',
	// 		is_account_page() ? 'active' : '',
	// 		esc_url( wc_get_page_permalink( 'myaccount' ) ),
	// 		esc_html__( 'Login', 'deux' )
	// 	);
	// }

	$pages = apply_filters( 'deux_woocommerce_page_header_links', $pages );

	if ( ! empty( $pages ) ) {
		printf( '<div class="woocommerce-page-header"><div class="container"><ul>%s</ul></div></div>', implode( "\n", $pages ) );
	}
}

add_action( 'deux_header_after', 'deux_woocommerce_pages_header', 20 );


/**
 * Display the main breadcrumb
 */
function deux_site_breadcrumb() {
	if ( get_post_meta( deux_get_the_id(), 'hide_breadcrumb', true ) ) {
		return;
	}

	if ( deux_get_option( 'show_breadcrumb' ) == false ) {
		return;
	}

	$yoast = get_option( 'wpseo_internallinks' );

	if ( function_exists( 'yoast_breadcrumb' ) && $yoast && $yoast['breadcrumbs-enable'] ) {
		yoast_breadcrumb( '<div class="breadcrumb">', '</div>' );
	} elseif ( function_exists( 'is_woocommerce' ) && is_woocommerce() ) {
		woocommerce_breadcrumb();
	} else {
		deux_breadcrumbs();
	}
}

/**
 * Display product badge count
 * 
 * @version 1.1.0
 * @return int
 */
function deux_product_badge_count(){
	if ( ! deux_get_option( 'product_badge_counter' ) ) {
		return;		
	}

	$args = array(
	    'posts_per_page'    => -1,
	    'post_type'         => 'product',
	    'post_status'       => 'publish',
	    'meta_key'          => '_is_new',
	    'meta_value'        => 'yes'
	);

	$posts_query = new WP_Query( $args );
	$the_count = $posts_query->post_count;

	if ( 
		( ( time() - ( 60 * 60 * 24 * deux_get_option( 'product_newness' ) ) ) < strtotime( get_the_time( 'Y-m-d' ) ) ) 
		|| $the_count > 0 
	)
	    return sprintf( '<span class="badge-counter" title="%1$s %2$s">%1$s</span>', 
	    					$the_count, _n( 'New Product', 'New Products', $the_count, 'deux' ) );
}

/**
 * Filter to archive title and add page title for singular pages
 *
 * @param string $title
 *
 * @return string
 */
function deux_the_archive_title( $title ) {
	if ( deux_is_shop() ) {
		$title = get_the_title( wc_get_page_id( 'shop' ) ) . deux_product_badge_count();
	} else if ( deux_is_checkout() ) {
		$title = get_the_title( get_option( 'woocommerce_checkout_page_id' ) );
	} else if ( deux_is_cart() ) {
		$title = get_the_title( get_option( 'woocommerce_cart_page_id' ) );
	} else if ( deux_is_wishlist_page() ) {
		$title = get_the_title( get_option( 'yith_wcwl_wishlist_page_id' ) );
	} else if ( deux_is_account_page() ) {
		$title = get_the_title( get_option( 'woocommerce_myaccount_page_id' ) );
	} else if ( is_category() || is_tag() || is_tax() ) {
		$title = single_term_title( '', false );
	} else if ( is_search() ) {
		$title = esc_html_x( 'Search Results..', 'index title', 'deux' );
	} else if ( is_home() ) {
		$title = 'page' == get_option( 'show_on_front' ) ? get_the_title( get_option( 'page_for_posts' ) ) : esc_html_x( 'Blog', 'index title', 'deux' );
	}

	return $title;
}

add_filter( 'get_the_archive_title', 'deux_the_archive_title' );

