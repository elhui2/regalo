<?php

/**
 * Enqueues front-end CSS for theme customization
 */
function deux_customize_css() {
	$css = '';
	// 404 Background image
	if ( is_404() ) {
		$image = deux_get_option( '404_bg' );

		if ( $image ) {
			$css .= 'body.error404 { background-image: url( ' . esc_url( $image ) . '); }';
		}
	}

	// Logo width
	$logo_width  = deux_get_option( 'logo_width' );
	$logo_height = deux_get_option( 'logo_height' );

	if ( $logo_width || $logo_height ) {
		$logo_css = '';

		if ( $logo_width ) {
			$logo_css .= 'width: ' . esc_attr( $logo_width ) . 'px;';
		}

		if ( $logo_height ) {
			$logo_css .= 'height: ' . esc_attr( $logo_height ) . 'px;';
		}

		$css .= '.site-branding .logo img {' . $logo_css . '}';
	}

	// Logo margin
	$logo_margin = deux_get_option( 'logo_position' );
	$logo_margin = array_filter( $logo_margin );

	if ( $logo_margin ) {
		$logo_css = '';

		foreach( $logo_margin as $pos => $value ) {
			$logo_css .= 'margin-' . $pos . ': ' . esc_attr( $value ) . ';';
		}

		$css .= '.site-branding .logo {' . $logo_css . '}';
	}

	// login 
	if( $login_modal_image = deux_get_option( 'login_modal_image' ) ) {
		$css .= '.login-modal-header { 
				background: url(' . esc_url( $login_modal_image ) . ') no-repeat center center; 
				background-size: cover; 
				padding: 120px 0; 
			}';
	}

	// Popup
	$css .= '.deux-popup.popup-layout-fullscreen, .deux-modal .deux-modal-backdrop {background-color: ' . esc_attr( deux_get_option( 'popup_overlay_color' ) ) . '; }';

	$css .= deux_customize_color_scheme_css();

	if( deux_get_option( 'enable_product_star_rating_color' ) ){

	$star = get_theme_mod( 'product_star_rating_color_gradient', array( 
				'start' => '#f9d423', 
				'end'   => '#ff4e50', 
				) ) ;
	$css .= '.woocommerce .star-rating span:before{'. Deux_Color::makeGradient( 'color', $star['start'], $star['end'] ).'; }';

	$css .= '.woocommerce p.stars:hover a:before{ color:'. $star['start'] .'; }';
	}

	if( 'duotone' == deux_get_option( 'topbar_color' ) ){
		$tb_duotone = get_theme_mod( 'topbar_duotone_color', array( 
					'start' => '#00dbde', 
					'end'   => '#fc00ff', 
					) ) ;
		$css .= '.topbar-duotone .topbar{'. Deux_Color::makeGradient( 'background', $tb_duotone['start'], $tb_duotone['end'] ).'; }';
    }
         
	wp_add_inline_style( 'deux', Deux_Http_Assets::minify_css( $css ) );
}

add_action( 'wp_enqueue_scripts', 'deux_customize_css', 20 );

/**
 * color scheme css
 */
function deux_customize_color_scheme_css(){

	$base_scheme = str_replace( '_palette', '', deux_get_option( 'base_color_scheme' ) );
	$predefined_color = deux_get_option( 'predefined_color_scheme' . $base_scheme ); 

	$styles = '.nav-menu li li a:before,
	          .site-navigation a:after,
	          .header-icon li.menu-item-cart span.count, 
			  .header-icon li.menu-item-wishlist span.count,
	          .header-transparent.header-text-light.header-hoverable .site-header:hover .nav-menu > li > a:after,
			  .header-transparent.header-hoverable.header-text-light .site-header:hover li.menu-item-cart span.count,
			  .header-transparent.header-hoverable.header-text-light .site-header:hover li.menu-item-wishlist span.count,
			  .header-transparent.header-hoverable.header-text-light .site-header:hover .menu-item-mobile-cart span.count,
			  .header-text-light .header-icon .menu-item-mobile-cart span.count,
			  .header-sticky .site-header.sticky .nav-menu > li > a:after, 
			  .header-sticky .site-header.headroom--not-top .nav-menu > li > a:after,
			  .header-sticky .site-header.sticky li.menu-item-cart span.count,
			  .header-sticky .site-header.sticky li.menu-item-wishlist span.count,
			  .header-sticky .site-header.sticky .menu-item-mobile-cart span.count,
			  .header-sticky .site-header.headroom--not-top li.menu-item-cart span.count,
			  .header-sticky .site-header.headroom--not-top li.menu-item-wishlist span.count,
			  .header-sticky .site-header.headroom--not-top .menu-item-mobile-cart span.count,
			  .mobile-menu .mobile-menu-bottom .count,
			  .menu-item-mobile-cart .count, 
			  .menu-item-mobile-wishlist .count,
			  .cart-panel__header .counter-cart-panel .count,
			  .accordion-tab span.active .count,
			  .woocommerce div.product .cart-container-functions .cart-action-loader .count,
			  .woocommerce div.product .woocommerce-tabs ul.tabs li.active a .counter,
			  .deux-product-slider2 .ps-content span.ps-price, .hfeed .site-main .read-more:before, .post-navigation-2 .read-more:before,
			  .woocommerce .widget_price_filter .ui-slider .ui-slider-handle, 
			  .woocommerce .widget_price_filter .ui-slider .ui-slider-range
			{ background-color: '. esc_attr( $predefined_color ) .'; }';

	$styles .= '.single-post .post-summary p a, 
				.single-post .post-summary p a:after,
				.owl-carousel .owl-dot.active span,
				.comment-respond .comment-form textarea:focus, 
				.comment-respond .comment-form input:not([type="submit"]):focus
			{ border-color:' . esc_attr( $predefined_color ) .'; }';		

	$styles .= '.nav-menu .mega-sub-menu ul li a:before,
				.sticky .entry-title a:after,
				.woocommerce div.product .price ins .amount,
				.woocommerce ul.products li.product .price ins .amount,
				.woocommerce div.product .product_meta a:hover,
				.woocommerce .woocommerce-breadcrumb a:hover, .woocommerce .woocommerce-breadcrumb .fa:hover,
				.woocommerce .product-toolbar .nav-previous:hover i, .woocommerce .product-toolbar .nav-next:hover i,
				.woocommerce table.shop_table .product-subtotal .amount,
				.woocommerce-cart .cart-collaterals table.shop_table .order-total .amount,
				.woocommerce-checkout form.checkout table.shop_table .order-total span.amount,
				.cart-panel .woocommerce-mini-cart__total .subtotal-number,
				.woocommerce .shop-toolbar .woocommerce-result-count .result-count__number,
				.woocommerce form.login .lost_password a
			{ color: '. esc_attr( $predefined_color ) .'; }';

	$styles .= deux_loader_color_css( esc_attr( $predefined_color ) );		

	return $styles;
}

/**
 * Loader color alternative
 * @param  string $color hex color
 * @return string
 */
function deux_loader_color_css( $color = '' ) {
    
    $base_color = new Deux_Color( $color ); // get color options
    $getHex = $base_color->getHex(); // hex color
    $getHue = round( $base_color->getHsl()['H'] ); // Hue color

	$css = '
		.loading-icon .dot .dot__color--1{
			background-color: #'.$getHex.';
		}
		.loading-icon .dot .dot__color--2{
			background-color: hsl( '.$getHue.', 100%, 75% );
		}
		.loading-icon .dot .dot__color--3{
			background-color: hsl( '.( $getHue + 35 ).', 80%, 50% );
		}';

	return $css;
}