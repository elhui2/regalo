<?php
/**
 * Custom template tags for this theme.
 *
 * @package Deux
 */

if( ! function_exists( 'deux_branding_site_identity' ) ) {
  /**
   * Site identity
   * 
   */
  function deux_branding_site_identity() {
	$logo = array(
		'type'      => deux_get_option( 'logo_type' ),
		'img_dark'  => deux_get_option( 'logo' ),
        'img_light' => deux_get_option( 'logo_light' ),
        'width' 	=> deux_get_option( 'logo_width' ) ? ' width="' . esc_attr( deux_get_option( 'logo_width' ) ) . '"' : '',
        'height' 	=> deux_get_option( 'logo_height' ) ? ' height="' . esc_attr( deux_get_option( 'logo_height' ) ) . '"' : '',
	);
	?>

	<a href="<?php echo esc_url( home_url( '/' ) ) ?>" class="logo">
		<?php if ( 'text' == $logo['type'] ) : ?>
			<span class="logo-text"><?php echo esc_html( get_bloginfo( 'name' ) ); ?></span>
		<?php else : ?>
			<img src="<?php echo esc_url( $logo['img_dark'] ); ?>" alt="<?php echo esc_html( get_bloginfo( 'name' ) ); ?>" class="logo-dark" <?php echo trim( $logo['width'] . $logo['height'] ) ?>>
			<img src="<?php echo esc_url( $logo['img_light'] ); ?>" alt="<?php echo esc_html( get_bloginfo( 'name' ) ); ?>" class="logo-light" <?php echo trim( $logo['width'] . $logo['height'] ) ?>>
		<?php endif; ?>
	</a>

	<?php if ( is_front_page() && is_home() ) : ?>
		<h1 class="site-title">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>
		</h1>
	<?php else : ?>
		<p class="site-title">
			<a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>
		</p>
	<?php endif; ?>

	<?php if ( ( $description = get_bloginfo( 'description', 'display' ) ) || is_customize_preview() ) : ?>
		<p class="site-description"><?php echo esc_html( $description ); /* WPCS: xss ok. */ ?></p>
	<?php endif; 

  }
}

/**
 * Change markup of archive and category widget to include .count for post count
 *
 * @param string $output
 *
 * @return string
 */
function deux_widget_archive_count( $output ) {
	$output = preg_replace( '|\((\d+)\)|', '<span class="count">\\1</span>', $output );

	return $output;
}

add_filter( 'wp_list_categories', 'deux_widget_archive_count' );
add_filter( 'get_archives_link', 'deux_widget_archive_count' );

if ( ! function_exists( 'deux_entry_meta' ) ) :
	/**
	 * Prints HTML with meta information for the current post-date/time and categories.
	 */
	function deux_entry_meta() {
		$time_string = sprintf(
			'<time class="entry-date published updated" datetime="%1$s">%2$s</time>',
			esc_attr( get_the_date( 'c' ) ),
			esc_html( get_the_date( get_option( 'date_format', 'd.m Y' ) ) )
		);

		$posted_on = is_singular() ? $time_string : '<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>';

		/* translators: used between list items, there is a space after the comma */
		$categories_list = get_the_category_list( ', ' );

        echo sprintf( '<span class="posted-on">%1$s</span> <span class="cat-links"> %2$s</span>', $posted_on, $categories_list );// WPCS: XSS OK.
	}
endif;

if ( ! function_exists( 'deux_entry_footer' ) ) :
	/**
	 * Prints HTML with meta information for post tags.
	 */
	function deux_entry_footer() {
		// Hide category and tag text for pages.
		if ( 'post' === get_post_type() ) {
			$tags_list = get_the_tag_list( '', ', ' );

			if ( $tags_list ) {
				printf( '<span class="tags-links">%1$s %2$s</span>', esc_attr__( 'tags : ', 'deux' ), $tags_list ); // WPCS: XSS OK.
			}
		}
	}
endif;


if ( ! function_exists( 'deux_single_navigation_2' ) ) :
	/**
	 *  Single post navigation modern
	 *
	 * @since  1.0
	 */
	function deux_single_navigation_2(){
		$img_prev[] = '';
		$img_next[] = '';
	    $prev = ( is_attachment() ) ? get_post( get_post()->post_parent ) : get_adjacent_post( false, '', true );
	    $next = get_adjacent_post( false, '', false );
    	$titlePrev = $prev ? get_the_title($prev->ID) : '';
    	$titleNext = $next ? get_the_title($next->ID): '';
    	$img_prev_container = '';
    	$img_next_container = '';

		if ( $prev && has_post_thumbnail( $prev->ID ) ) {
	    	$img_prev = wp_get_attachment_image_src( get_post_thumbnail_id( $prev->ID ), 'thumbnail' );
	    	$img_prev_container = '<div class="image-nav" style="background-image:url('.esc_url($img_prev[0]).');"></div>';
		}


	    if ( $next && has_post_thumbnail( $next->ID ) ) {
	    	$img_next = wp_get_attachment_image_src( get_post_thumbnail_id( $next->ID ), 'thumbnail' );
	    	$img_next_container = '<div class="image-nav" style="background-image:url('.esc_url($img_next[0]).');"></div>';

	    }

		$previous   = get_previous_post_link( '<div class="nav-previous">%link</div>', '<span class="nav-text">'.esc_attr__( 'previous article', 'deux' ).'</span>'.$img_prev_container.'<h4>'.$titlePrev.'</h4><span class="read-more">'. esc_attr__( 'view article', 'deux' ).'</span>', true );


		$next       = get_next_post_link( '<div class="nav-next">%link</div>', '<span class="nav-text">'.esc_attr__( 'next article', 'deux' ).'</span>'.$img_next_container.'<h4>'.$titleNext.'</h4><span class="read-more">'. esc_attr__( 'view article', 'deux' ).'</span>', true );

		// Only add markup if there's somewhere to navigate to.
		if ( $previous || $next ) {       
			echo _navigation_markup( $previous . $next, 'post-navigation-2' );
		}
	}
endif;

if ( ! function_exists( 'deux_currency_switcher' ) ) :
	/**
	 * Print HTML of currency switcher
	 * It requires plugin WooCommerce Currency Switcher installed
	 */
	function deux_currency_switcher() {
		if ( ! class_exists( 'WOOCS' ) ) {
			return;
		}

		global $WOOCS;

		$currencies    = $WOOCS->get_currencies();
		$currency_list = array();
		foreach ( $currencies as $key => $currency ) {
			if ( $WOOCS->current_currency == $key ) {
				array_unshift( $currency_list, sprintf(
					'<li><a href="#" class="woocs_flag_view_item woocs_flag_view_item_current" data-currency="%s">%s</a></li>',
					esc_attr( $currency['name'] ),
					esc_html( $currency['name'] )
				) );
			} else {
				$currency_list[] = sprintf(
					'<li><a href="#" class="woocs_flag_view_item" data-currency="%s">%s</a></li>',
					esc_attr( $currency['name'] ),
					esc_html( $currency['name'] )
				);
			}
		}
		?>
		<div class="currency list-dropdown">
			<span class="current"><?php echo esc_html( $currencies[ $WOOCS->current_currency ]['name'] ); ?>
				<span class="caret"></span></span>
			<ul>
				<?php echo implode( "\n\t", $currency_list ); ?>
			</ul>
		</div>
		<?php
	}
endif;

if ( ! function_exists( 'deux_language_switcher' ) ) :
	/**
	 * Print HTML of language switcher
	 * It requires plugin WPML installed
	 */
	function deux_language_switcher() {
		$languages = function_exists( 'icl_get_languages' ) ? icl_get_languages() : apply_filters( 'deux_languages', array() );

		if ( empty( $languages ) ) {
			return;
		}

		$lang_list = array();
		$current   = '';

		foreach ( (array) $languages as $code => $language ) {
			if ( ! $language['active'] ) {
				$lang_list[] = sprintf(
					'<li class="%s"><a href="%s">%s</a></li>',
					esc_attr( $code ),
					esc_url( $language['url'] ),
					esc_html( $language['translated_name'] )
				);
			} else {
				$current = $language;
				array_unshift( $lang_list, sprintf(
					'<li class="%s"><a href="%s">%s</a></li>',
					esc_attr( $code ),
					esc_url( $language['url'] ),
					esc_html( $language['translated_name'] )
				) );
			}
		}
		?>

		<div class="language list-dropdown">
			<span class="current"><?php echo esc_html( $current['language_code'] ) ?><span class="caret"></span></span>
			<ul>
				<?php echo implode( "\n\t", $lang_list ); ?>
			</ul>
		</div>

		<?php
	}
endif;

if ( ! function_exists( 'deux_has_page_header' ) ) :
	/**
	 * Check if current page has page header
	 *
	 * @return bool
	 */
	function deux_has_page_header() {
		if ( is_front_page() && ! is_home() ) {
			return false;
		} 

		if ( is_page_template( 'templates/fullwidth.php' ) ) {
			return false;
		} 

		if ( get_post_meta( deux_get_the_id(), 'hide_page_header', true ) ) {
			return false;
		} 

		if ( is_singular( array( 'post', 'product', 'portfolio' ) ) ) {
			return false;
		} 

		if ( is_404() ) {
			return false;
		} 

		if ( is_post_type_archive( 'portfolio' ) ) {
			return true;
		} 

		if ( deux_is_wishlist_page() ) {
			return false;
		} 

		if ( deux_is_order_tracking_page() ) {
			return false;
		} 

		if ( deux_is_woocommerce_activated() ) {
			if ( is_account_page() || is_cart() ) {
				return false;
			} 
		}

		return deux_get_option( 'page_header_enable' );
	}
endif;

if ( ! function_exists( 'deux_get_page_header_image' ) ) :
	/**
	 * Get page header image URL
	 *
	 * @return string
	 */
	function deux_get_page_header_image() {
		if ( ! deux_has_page_header() ) {
			return '';
		}

		if ( deux_is_checkout() || deux_is_rnx_page() ) {
			return '';
		}

		if ( function_exists( 'is_woocommerce' ) && is_woocommerce() ) {

			if ( is_product_taxonomy() ) {
				$term_id      = get_queried_object_id();
				$thumbnail_id = absint( get_term_meta( $term_id, 'page_header_image_id', true ) );

				if ( $thumbnail_id ) {
					$thumbnail = wp_get_attachment_image_src( $thumbnail_id, 'full' );
					return $thumbnail[0];
				}
			} 

			$shop_image = get_post_meta( deux_get_the_id(), 'page_header_bg', true );
			if ( $shop_image ) {
				return current( wp_get_attachment_image_src( $shop_image, 'full' ) );
			}			
			
			return deux_get_option( 'shop_page_header_bg' );
		}		

		if ( ! is_front_page() ) {			
			if ( $image = get_post_meta( deux_get_the_id(), 'page_header_bg', true ) ){
				return current( wp_get_attachment_image_src( $image, 'full' ) );					
			}			
		} 

		if ( is_page() ) {
			$image = get_post_meta( get_the_ID(), 'page_header_bg', true );
			$image = $image ? wp_get_attachment_image_src( $image, 'full' ) : get_the_post_thumbnail_url( get_the_ID(), 'full' );
			if( $image ){
				return $image[0];
			}
		} 

		if ( is_post_type_archive( 'portfolio' ) || is_tax( 'portfolio_type' ) ) {
			return deux_get_option( 'portfolio_page_header_bg' );
		} 

		return deux_get_option( 'page_header_bg' );
	}
endif;

if ( ! function_exists('deux_get_layout') ) :
	/**
	 * Get layout base on current page
	 *
	 * @return string
	 */
	function deux_get_layout() {
		$view = Deux_Frontend_View::Access();		

		if ( is_404() || is_singular( array(
					'product',
					'portfolio',
				) ) || is_post_type_archive( array( 'portfolio' ) ) || is_tax( 'portfolio_type' ) || deux_is_order_tracking_page() || is_page_template( 'templates/fullwidth.php' )
			) {
				return 'no-sidebar';
		}

		if ( in_array( $view, array( 'cart', 'checkout', 'account', 'wishlist', 'rnx' ) ) ) {
			return 'no-sidebar';
		}

		if ( get_post_meta( deux_get_the_id(), 'custom_layout', true ) ) {
			return get_post_meta( deux_get_the_id(), 'layout', true );
		}

		return deux_get_option( 'layout_' . $view );
	}
endif;

if ( ! function_exists( 'deux_get_content_columns' ) ) :
	/**
	 * Get CSS classes for content columns
	 *
	 * @param string $layout
	 *
	 * @return array
	 */
	function deux_get_content_columns( $layout = null ) {
		$layout = $layout ? $layout : deux_get_layout();

		if ( 'no-sidebar' == $layout ) {
			return array();
		}

		if ( is_page() ) {
			return array('col-md-9', 'col-sm-12', 'col-xs-12');
		}

		return array('col-md-8', 'col-sm-12', 'col-xs-12');
	}

endif;

if ( ! function_exists( 'deux_content_columns' ) ) :

	/**
	 * Display CSS classes for content columns
	 *
	 * @param string $layout
	 */
	function deux_content_columns( $layout = null ) {
		echo implode( ' ', deux_get_content_columns( $layout ) );
	}

endif;

if ( ! function_exists( 'the_comments_pagination' ) ) :
	/**
	 * Back compact function for comments pagination
	 *
	 * @param array $args
	 */
	function the_comments_pagination( $args = array() ) {
		if ( get_comment_pages_count() < 1 || get_option( 'page_comments' ) ) {
			return;
		}
		?>
		<nav class="navigation comments-pagination" role="navigation">
			<h2 class="screen-reader-text"><?php esc_html_e( 'Comments navigation', 'deux' ) ?></h2>
			<div class="nav-links">
				<?php paginate_comments_links( $args ) ?>
			</div>
		</nav>
		<?php
	}

endif;

if ( ! function_exists( 'deux_entry_thumbnail' ) ) :
	/**
	 * Show entry thumbnail base on its format
	 *
	 * @since  1.0
	 */
	function deux_entry_thumbnail( $size = 'thumbnail' ) {
		$html = '';

		switch ( get_post_format() ) {
			case 'gallery':
				$images = get_post_meta( get_the_ID(), 'images' );

				if ( empty( $images ) ) {
					break;
				}

				$gallery = array();
				foreach ( $images as $image ) {
					$gallery[] = wp_get_attachment_image( $image, $size );
				}
				$html .= '<div class="entry-gallery entry-image">' . implode( '', $gallery ) . '</div>';
				break;

			case 'audio':
				$audio = get_post_meta( get_the_ID(), 'audio', true );
				if ( ! $audio ) {
					break;
				}

				// If URL: show oEmbed HTML or jPlayer
				if ( filter_var( $audio, FILTER_VALIDATE_URL ) ) {
					if ( $oembed = @wp_oembed_get( $audio, array( 'width' => 1140 ) ) ) {
						$html .= $oembed;
					} else {
						$html .= '<div class="audio-player">' . wp_audio_shortcode( array( 'src' => $audio ) ) . '</div>';
					}
				} else {
					$html .= $audio;
				}
				break;

			case 'video':
				$video = get_post_meta( get_the_ID(), 'video', true );
				if ( ! $video ) {
					break;
				}

				// If URL: show oEmbed HTML
				if ( filter_var( $video, FILTER_VALIDATE_URL ) ) {
					if ( $oembed = @wp_oembed_get( $video, array( 'width' => 1140 ) ) ) {
						$html .= $oembed;
					} else {
						$atts = array(
							'src'   => $video,
							'width' => 1140,
						);

						if ( has_post_thumbnail() ) {
							$atts['poster'] = get_the_post_thumbnail_url( get_the_ID(), 'full' );
						}
						$html .= wp_video_shortcode( $atts );
					}
				} // If embed code: just display
				else {
					$html .= $video;
				}
				break;

			default:
				$html = get_the_post_thumbnail( get_the_ID(), $size );

				break;
		}

		echo apply_filters( __FUNCTION__, $html, get_post_format() );
	}

endif;

if ( ! function_exists( 'deux_is_order_tracking_page' ) ) :
	/**
	 * Check if current page is order tracking page
	 *
	 * @return bool
	 */
	function deux_is_order_tracking_page() {
		$page_id = get_option( 'deux_order_tracking_page_id' );
		$page_id = deux_get_translated_object_id( $page_id );

		if ( ! $page_id ) {
			return false;
		}

		return is_page( $page_id );
	}
endif;

if ( ! function_exists( 'deux_get_translated_object_id' ) ) :
	/**
	 * Get translated object ID if the WPML plugin is installed
	 * Return the original ID if this plugin is not installed
	 *
	 * @param int    $id            The object ID
	 * @param string $type          The object type 'post', 'page', 'post_tag', 'category' or 'attachment'. Default is 'page'
	 * @param bool   $original      Set as 'true' if you want WPML to return the ID of the original language element if the translation is missing.
	 * @param bool   $language_code If set, forces the language of the returned object and can be different than the displayed language.
	 *
	 * @return mixed
	 */
	function deux_get_translated_object_id( $id, $type = 'page', $original = true, $language_code = false ) {
		if ( function_exists( 'wpml_object_id_filter' ) ) {
			return wpml_object_id_filter( $id, $type, $original, $language_code );
		} elseif ( function_exists( 'icl_object_id' ) ) {
			return icl_object_id( $id, $type, $original, $language_code );
		}

		return $id;
	}
endif;

if ( ! function_exists( 'deux_get_mega_menu_setting_default' ) ) :
	/**
	 * Get the default mega menu settings of a menu item
	 *
	 * @return array
	 */
	function deux_get_mega_menu_setting_default() {
		return apply_filters(
			'deux_mega_menu_setting_default',
			array(
				'mega'         => false,
				'icon'         => '',
				'hide_text'    => false,
				'disable_link' => false,
				'content'      => '',
				'width'        => '',
				'border'       => array(
					'left' => 0,
				),
				'background'   => array(
					'image'      => '',
					'color'      => '',
					'attachment' => 'scroll',
					'size'       => '',
					'repeat'     => 'no-repeat',
					'position'   => array(
						'x'      => 'left',
						'y'      => 'top',
						'custom' => array(
							'x' => '',
							'y' => '',
						),
					),
				),
			)
		);
	}
endif;

if ( ! function_exists( 'deux_parse_args' ) ) :
	/**
	 * Recursive merge user defined arguments into defaults array.
	 *
	 * @param array $args
	 * @param array $default
	 *
	 * @return array
	 */
	function deux_parse_args( $args, $default = array() ) {
		$args   = (array) $args;
		$result = $default;

		foreach ( $args as $key => $value ) {
			if ( is_array( $value ) && isset( $result[ $key ] ) ) {
				$result[ $key ] = deux_parse_args( $value, $result[ $key ] );
			} else {
				$result[ $key ] = $value;
			}
		}

		return $result;
	}

endif;

if ( ! function_exists( 'deux_portfolio_filter' ) ) :
	/**
	 * Get portfolio types and display it as a filter for Isotope script
	 */
	function deux_portfolio_filter() {
		$types = get_terms( array(
			'taxonomy'   => 'portfolio_type',
			'hide_empty' => true,
		) );

		if ( ! $types || is_wp_error( $types ) || is_null( $types ) || 1 === count( $types ) ) {
			return;
		}

		$filter   = array();
		$filter[] = '<li data-filter="*"><span>' . esc_html__( 'All', 'deux' ) . '</span></li>';

		foreach ( $types as $type ) {
			$filter[] = sprintf( '<li data-filter=".portfolio_type-%s"><span>%s</span></li>', esc_attr( $type->slug ), esc_html( $type->name ) );
		}

		printf(
			'<div class="portfolio-filter"><ul class="filter">%s</ul></div>',
			implode( "\n\t", $filter )
		);
	}
endif;

if ( ! function_exists( 'deux_shopping_cart_icon' ) ) {
	/**
	 * Get shopping cart icon HTML
	 */
	function deux_shopping_cart_icon( $echo = true ) {
		$source = deux_get_option( 'shop_cart_icon_source' );
		$icon   = deux_get_svg_icon_html( deux_get_option( 'shop_cart_icon' ) );

		if ( 'image' == $source ) {
			$width  = floatval( deux_get_option( 'shop_cart_icon_width' ) );
			$height = floatval( deux_get_option( 'shop_cart_icon_height' ) );

			$width  = $width ? ' width="' . $width . 'px"' : '';
			$height = $height ? ' height="' . $height . 'px"' : '';

			$dark  = deux_get_option( 'shop_cart_icon_image' );
			$light = deux_get_option( 'shop_cart_icon_image_light' );
			$light = $light ? $light : $dark;

			if ( $dark ) {
				$icon = sprintf(
					'<span class="shopping-cart-icon"><img src="%1$s" alt="%2$s" %3$s class="icon-dark"><img src="%4$s" alt="%2$s" %3$s class="icon-light"></span>',
					esc_url( $dark ),
					esc_attr__( 'Shopping Cart', 'deux' ),
					$width . $height,
					esc_url( $light )
				);
			}
		} 

		if ( ! $echo ) {
			return $icon;
		}

		echo trim( $icon );
	}
}

if ( ! function_exists( 'deux_header_icons' ) ) :
	/**
	 * Print header icons base on settings in Customizer
	 *
	 * @param string $header_version
	 * @param string $position
	 */
	function deux_header_icons( $header_version = 'v1', $position = 'right' ) {
		switch ( $header_version ) {
			case 'v3':
				$icons = deux_get_option( 'header_icons_' . $position );
				break;
			case 'v4':
				$icons = deux_get_option( 'header_icons_' . $position . '_v4' );
				break;

			case 'v5':
				$icons = deux_get_option( 'header_icons_' . $position );
				break;

			case 'v6':
				$icons = deux_get_option( 'header_icons_' . $position );
				break;

			default:
				$icons = deux_get_option( 'header_icons' );
				break;
		}

		if ( empty( $icons ) ) {
			return;
		}

		foreach ( (array) $icons as $icon ) {
			switch ( $icon ) {
				case 'cart':
					if ( ! deux_is_woocommerce_activated() ) {
						break;
					}
					printf(
						'<li class="menu-item menu-item-cart">
							<a href="%s" class="cart-contents" data-toggle="slide" data-target="cart-panel" data-accordion-item="cart">
								%s
								<span class="count cart-counter">%s</span>
							</a>
						</li>',
						esc_url( wc_get_cart_url() ),
						deux_shopping_cart_icon( false ),
						intval( WC()->cart->get_cart_contents_count() )
					);
					break;

				case 'wishlist':
					if ( defined( 'YITH_WCWL' ) ) {
						printf(
							'<li class="menu-item menu-item-wishlist">
								<a href="%s" class="wishlist-contents" data-toggle="slide" data-target="cart-panel" data-accordion-item="wishlist">%s<span class="count wishlist-counter">%s</span>
								</a>
							</li>',
							esc_url( get_permalink( yith_wcwl_object_id( get_option( 'yith_wcwl_wishlist_page_id' ) ) ) ),
							deux_get_svg_icon_html( 'heart-wishlist-like' ),
							yith_wcwl_count_products()
						);
					} 
					break;

				case 'login':
					if ( ! deux_is_woocommerce_activated() ) {
						break;
					}

					printf(
						'<li class="menu-item menu-item-account"><a href="%s" %s>%s</a></li>',
						esc_url( wc_get_account_endpoint_url( 'dashboard' ) ),
    					( is_user_logged_in() ? '' : 'data-izimodal-open="#login-modal" data-izimodal-transitionin="fadeInDown"' ),
    					( is_user_logged_in() ? get_avatar( get_the_author_meta( 'ID', get_current_user_id() ), 30 ) : deux_get_svg_icon_html( 'user-account-people' ) )
					);
					
					break;

				case 'search':
					echo '<li class="menu-item menu-item-search"><a href="#" data-toggle="modal" data-target="search-modal">'.deux_get_svg_icon_html( 'search' ).'</a></li>';
					break;
			}
		}
	}
endif;


if ( ! function_exists( 'deux_mobile_header_icon' ) ) :
	/**
	 * Display the header icon base on settings in Customizer
	 */
	function deux_mobile_header_icon() {
		if ( ! deux_is_woocommerce_activated() ) {
			return;
		}

		$icon = deux_get_option( 'mobile_header_icon' );

		switch ( $icon ) {
			case 'cart':
				printf(
					'<a href="%s" class="cart-contents  menu-item-mobile-cart hidden-lg" data-toggle="slide" data-target="cart-panel" data-accordion-item="cart">%s<span class="count cart-counter--mobile %s"></span></a>',
					esc_url( wc_get_cart_url() ),
					deux_shopping_cart_icon( false ),
					deux_is_cart_empty( 'cart_empty' )
				);

				break;

			case 'wishlist':
				if ( defined( 'YITH_WCWL' ) ) {
					printf(
						'<a href="%s" class="wishlist-contents menu-item-mobile-wishlist hidden-lg" data-toggle="slide" data-target="cart-panel" data-accordion-item="wishlist">
							%s
							<span class="count wishlist-counter--mobile %s"></span>
						</a>',
						esc_url( get_permalink( yith_wcwl_object_id( get_option( 'yith_wcwl_wishlist_page_id' ) ) ) ),
						deux_get_svg_icon_html( 'heart-wishlist-like' ),
						( (int) yith_wcwl_count_products() == 0 ) ? 'wishlist_empty' : ''
					);
				}
				break;
		}
	}
endif;

function deux_schema_attribute() {
	$microdata_attr = 'http://schema.org/WebPage';

	if ( is_singular( 'post' ) || is_home() || is_archive() )
		$microdata_attr = 'http://schema.org/Blog';

	else if ( is_search() ) 
		$microdata_attr = 'http://schema.org/SearchResultsPage';
	
	return $microdata_attr;
}


/**
 * Get id for new product
 *
 * @return array
 */

function deux_get_new_product_ids() {
	// Load from cache.
	$product_ids = get_transient( 'deux_woocommerce_products_new' );

	// Valid cache found.
	if ( false !== $product_ids ) {
		return $product_ids;
	}

	$product_ids = array();

	// Get products which are set as new.
	$meta_query = WC()->query->get_meta_query();
	$meta_query[] = array(
		'key'   => '_is_new',
		'value' => 'yes',
	);
	$new_products = new WP_Query( array(
		'posts_per_page' => -1,
		'post_type'      => 'product',
		'fields'         => 'ids',
		'meta_query'     => $meta_query,
	) );

	if ( $new_products->have_posts() ) {
		$product_ids = array_merge( $product_ids, $new_products->posts );
	}

	// Get products after selected days.
	$newness = intval( deux_get_option( 'product_newness' ) );

	if ( $newness > 0 ) {
		$new_products = new WP_Query( array(
			'posts_per_page' => -1,
			'post_type'      => 'product',
			'fields'         => 'ids',
			'date_query'     => array(
				'after' => date( 'Y-m-d', strtotime( '-' . $newness . ' days' ) )
			)
		) );

		if ( $new_products->have_posts() ) {
			$product_ids = array_merge( $product_ids, $new_products->posts );
		}
	}

	set_transient( 'deux_woocommerce_products_new', $product_ids, DAY_IN_SECONDS );

	return $product_ids;
}

/**
 * ajax login modal
 *
 * @return array
 */

function deux_login_authenticate() {
	
	if ( isset( $_POST['creds'] ) ){
		$creds = wp_unslash( $_POST['creds'] ); 
	}

	$user = wp_signon( $creds );

	if ( is_wp_error( $user ) ) {
		wp_send_json_error( $user->get_error_message() );
	} else {
		wp_send_json_success();
	}
}

Deux_Http_Ajaxmanager::register_function( 'deux_login_authenticate' );