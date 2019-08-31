<?php
/**
 * Custom functions that act independently of the theme templates.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Deux
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 *
 * @return array
 */
function deux_body_classes( $classes ) {
	// Adds a class of group-blog to blogs with more than 1 published author.
	if ( is_multi_author() ) {
		$classes[] = 'group-blog';
	}

	if ( ! deux_get_option( 'page_transition' ) ) {
		$classes[] = 'no-transition';
	}

	// Adds a class of layout style
	$classes[] = deux_get_option( 'layout_style' );

	// Adds a class of layout
	$classes[] = 'sidebar-' . deux_get_layout();

	// Adds a class of hfeed to non-singular pages.
	if ( ! is_singular() ) {
		$classes[] = 'hfeed';
	}

	// Adds classes of topbar
	if ( deux_get_option( 'topbar_enable' ) ) {
		$classes[] = 'topbar-enabled';
		$classes[] = 'topbar-' . deux_get_option( 'topbar_color' );
	} else {
		$classes[] = 'topbar-disabled';
	}

	// Adds a class of header layout
	$classes[] = 'header-' . deux_get_option( 'header_layout' );

	// Adds a class for header sticky
	$sticky = deux_get_option( 'header_sticky' );
	if ( $sticky && 'none' != $sticky ) {
		$classes[] = 'header-sticky';
		$classes[] = 'header-sticky-' . $sticky;
	}

	// Adds classes of header background
	// Only apply text color for header transparent
	$default_header_bg    = deux_get_option( 'header_bg' );
	$default_header_color = deux_get_option( 'header_text_color' );

	if ( deux_has_page_header() ) {
		if ( 'minimal' == deux_get_option( 'page_header_style' ) ) {
			$classes[] = 'header-white';
		} else {
			if ( deux_is_checkout() || deux_is_rnx_page() ) {
				$classes[] = 'header-white';
			} elseif ( is_page() ) {
				$header_bg    = get_post_meta( get_the_ID(), 'site_header_bg', true );
				$header_color = get_post_meta( get_the_ID(), 'site_header_text_color', true );
				$header_bg    = $header_bg ? $header_bg : $default_header_bg;
				$header_color = $header_color ? $header_color : $default_header_color;

				$classes[] = 'header-' . $header_bg;

				if ( 'transparent' == $header_bg ) {
					$classes[] = 'header-text-' . $header_color;
				}
			} elseif ( is_home() ) {
				$blog_page_id = get_option( 'page_for_posts' );
				$header_bg    = get_post_meta( $blog_page_id, 'site_header_bg', true );
				$header_color = get_post_meta( $blog_page_id, 'site_header_text_color', true );
				$header_bg    = $header_bg ? $header_bg : $default_header_bg;
				$header_color = $header_color ? $header_color : $default_header_color;

				$classes[] = 'header-' . $header_bg;

				if ( 'transparent' == $header_bg ) {
					$classes[] = 'header-text-' . $header_color;
				}
			} elseif ( deux_is_shop() ) {
				$shop_page_id = wc_get_page_id( 'shop' );
				$header_bg    = get_post_meta( $shop_page_id, 'site_header_bg', true );
				$header_color = get_post_meta( $shop_page_id, 'site_header_text_color', true );
				$header_bg    = $header_bg ? $header_bg : $default_header_bg;
				$header_color = $header_color ? $header_color : $default_header_color;

				$classes[] = 'header-' . $header_bg;

				if ( 'transparent' == $header_bg ) {
					$classes[] = 'header-text-' . $header_color;
				}
			} elseif ( is_post_type_archive( 'portfolio' ) || is_tax( 'portfolio_type' ) ) {
				$portfolio_page_id = get_option( 'deux_portfolio_page_id' );
				$header_bg         = get_post_meta( $portfolio_page_id, 'site_header_bg', true );
				$header_color      = get_post_meta( $portfolio_page_id, 'site_header_text_color', true );
				$header_bg         = $header_bg ? $header_bg : $default_header_bg;
				$header_color      = $header_color ? $header_color : $default_header_color;

				$classes[] = 'header-' . $header_bg;

				if ( 'transparent' == $header_bg ) {
					$classes[] = 'header-text-' . $header_color;
				}
			} else {
				$classes[] = 'header-' . $default_header_bg;

				if ( 'transparent' == $default_header_bg ) {
					$classes[] = 'header-text-' . deux_get_option( 'header_text_color' );
				}
			}
		}
	} else {
		if ( is_404() ) {
			$classes[] = 'header-white';
		} elseif ( ( is_front_page() && ! is_home() ) || is_page_template( 'templates/fullwidth.php' ) ) {
			$classes[] = 'header-' . $default_header_bg;

			if ( 'transparent' == $default_header_bg ) {
				$classes[] = 'header-text-' . deux_get_option( 'header_text_color' );
			}
		} elseif ( is_page() ) {
			$header_bg    = get_post_meta( get_the_ID(), 'site_header_bg', true );
			$header_color = get_post_meta( get_the_ID(), 'site_header_text_color', true );
			$header_bg    = $header_bg ? $header_bg : 'white';
			$header_color = $header_color ? $header_color : 'dark';

			$classes[] = 'header-' . $header_bg;

			if ( 'transparent' == $header_bg ) {
				$classes[] = 'header-text-' . $header_color;
			}
		} else {
			$classes[] = 'header-white';
		}
	}

	// Adds a class for header hover effect
	if ( deux_get_option( 'header_hover' ) ) {
		$classes[] = 'header-hoverable';
	}

	// Adds classes of page header
	$classes[] = deux_has_page_header() ? 'has-page-header' : 'no-page-header';
	$classes[] = 'page-header-style-' . deux_get_option( 'page_header_style' );
	if ( 'minimal' != deux_get_option( 'page_header_style' ) ) {
		$classes[] = deux_get_page_header_image() ? 'page-header-image' : 'page-header-color';
	}

	if ( deux_has_page_header() ) {
		if ( deux_is_checkout() || deux_is_rnx_page() ) {
			$color = 'dark';
		} elseif ( is_singular() ) {
			$color = get_post_meta( get_the_ID(), 'page_header_text_color', true );
			$color = $color ? $color : deux_get_option( 'page_header_text_color' );
		} elseif ( function_exists( 'is_woocommerce' ) && is_woocommerce() ) {
			$color = deux_get_option( 'shop_page_header_text_color' );

			if ( is_product_category() ) {
				$term_id    = get_queried_object_id();
				$term_color = get_term_meta( $term_id, 'page_header_text_color', true );
				$color      = $term_color ? $term_color : $color;
			}
		} elseif ( is_post_type_archive( 'portfolio' ) || is_tax( 'portfolio_type' ) ) {
			// This is masonry style because we checked has_page_header before
			$color = deux_get_option( 'portfolio_page_header_text_color' );
		} elseif ( is_home() && ! is_front_page() ) {
			$posts_page_id = get_option( 'page_for_posts' );

			if ( $posts_page_id ) {
				$color = get_post_meta( $posts_page_id, 'page_header_text_color', true );
				$color = $color ? $color : deux_get_option( 'page_header_text_color' );
			} else {
				$color = deux_get_option( 'page_header_text_color' );
			}
		} else {
			$color = deux_get_option( 'page_header_text_color' );
		}

		$classes[] = 'page-header-text-' . $color;
	}

	// Adds a class for hidden page title
	if ( is_page() && get_post_meta( get_the_ID(), 'hide_page_title', true ) ) {
		$classes[] = 'page-title-hidden';
	}

	// Adds a class of product hover image
	if ( ! in_array( deux_get_option( 'products_item_style' ), array( 'slider', 'zoom' ) ) && deux_get_option( 'product_hover_thumbnail' ) ) {
		$classes[] = 'shop-hover-thumbnail';
	}

	// Adds a class of product quick view
	if ( deux_get_option( 'product_quickview' ) ) {
		$classes[] = 'product-quickview-enable';
	}

	// Adds a class of order tracking page
	if ( deux_is_order_tracking_page() ) {
		$classes[] = 'woocommerce-page woocommerce-order-tracking';
	}

	if ( deux_is_rnx_page() ){
		$classes[] = 'woocommerce-page woocommerce-rnx-page';
	}

	// Add a class of blog layout
	if ( is_singular( 'post' ) && deux_get_option( 'single_post_layout' )) {
		$classes[] = 'single-layout-2';
	}
	
	// Add a class of blog layout
	$classes[] = 'blog-' . deux_get_option( 'blog_layout' );

	// Adds a class of single product layout
	if ( is_singular( array( 'product' ) ) ) {
		$classes[] = 'product-' . deux_get_option( 'single_product_style' );
	}

	// Adds a class of shop navigation type
	$classes[] = 'shop-navigation-' . deux_get_option( 'shop_nav_type' );

	if ( is_post_type_archive( 'portfolio' ) || is_tax( 'portfolio_type' ) ) {
		$classes[] = 'portfolio-' . deux_get_option( 'portfolio_style' );
	}

	// Adds a class for showing product buttons of shop page on mobile
	if ( deux_get_option( 'mobile_shop_add_to_cart' ) ) {
		$classes[] = 'mobile-shop-buttons';
	}

	if (deux_get_option( 'footer_fixed' )){
		$classes[] = 'footer-fixed';
	}


	return $classes;
}

add_filter( 'body_class', 'deux_body_classes' );

/**
 * body attribute
 * @return array
 */
function deux_attr_body() {
    $attr = array();
	$data_loader = deux_get_option( 'data_loader_styles' );
    $data_loader_color = deux_get_option( 'data_loader_color' );

    if( deux_get_option( 'page_transition' ) ) {
      $attr[] = 'data-loader=' . esc_attr( $data_loader );

      if( ! empty( $data_loader_color ) ) {
        $attr[] = 'data-loader-color=' . esc_attr( $data_loader_color );
      }

    }

    echo implode( ' ', $attr );
}

/**
 * Open content container
 */
function deux_open_content_container() {
	$class = 'container';

	if (
		( deux_is_woocommerce_activated() && ( is_shop() || is_product_taxonomy() || is_product() ) ) ||
		is_page_template( 'templates/fullwidth.php' ) ||
		( ( is_post_type_archive( 'portfolio' ) || is_tax( 'portfolio_type' ) ) && 'fullwidth' == deux_get_option( 'portfolio_style' ) )
	) {
		$class = 'deux-container';
	}

	$class = apply_filters( 'deux_site_content_container_class', $class );

	echo '<div class="' . esc_attr( $class ) . '">';

	if ( 'no-sidebar' != deux_get_layout() ) {
		echo '<div class="row">';
	}
}

add_action( 'deux_content_before', 'deux_open_content_container', 5 );

/**
 * Close content container
 */
function deux_close_content_container() {
	echo '</div>';

	if ( 'no-sidebar' != deux_get_layout() ) {
		echo '</div>';
	}
}

add_action( 'deux_content_after', 'deux_close_content_container', 50 );

/**
 * Add icon list as svg at the footer
 * It is hidden
 */
function deux_include_shadow_icons() {
	echo '<div id="svg-defs" class="svg-defs hidden">';
	include get_template_directory() . '/assets/images/sprite.svg';
	echo '</div>';
}

add_action( 'deux_site_before', 'deux_include_shadow_icons' );