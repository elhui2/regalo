<?php
/**
 * Custom functions that act in the footer.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Deux
 */

/**
 * Display Footer Newsletter
 *
 * @since 1.0.0
 */
function deux_footer_content() {
	if ( ! deux_get_option( 'footer_content_enable' ) || is_404() ) {
		return;
	}

	$content = deux_get_option( 'footer_content' );

	if ( empty( $content ) ) {
		return;
	}
	?>

	<div class="footer-content">
		<div class="deux-container">
			<?php echo do_shortcode( wp_kses_post( $content ) ); ?>
		</div>
	</div>

	<?php
}

add_action( 'deux_footer', 'deux_footer_content', 5 );

/**
 * Display Footer Gototop
 *
 * @since 1.0.0
 */
function deux_footer_gototop() {
	if( is_404() ) {
		return;
	} 

	if ( deux_get_option( 'footer_gotop' ) ) {
		echo '<div id="gototop">' . deux_get_svg_icon_html( 'backtotop-arrow' ) . '</div>';
	}
} 

add_action( 'deux_footer_after', 'deux_footer_gototop', 5 );

/**
 * Add /section if fixed footer to header
 */
function deux_footer_fixed_footer() {
	if ( deux_get_option( 'footer_fixed' ) ){
		echo '</div>';
	}
}
add_action( 'deux_footer_before', 'deux_footer_fixed_footer' );

/**
 * Display widgets on footer
 */
function deux_footer_widgets() {
	deux_in_preview( '<div class="el-customize-footer-widgets">' );

	if ( ! deux_get_option( 'footer_widgets' ) ) {
		return;
	}

	$layout = deux_get_option( 'footer_widgets_layout' );
	$colums = array(
		'2-columns'       => 2,
		'3-columns'       => 3,
		'4-columns'       => 4,
		'4-columns-equal' => 4,
	);
	?>

	<div class="footer-widgets widgets-area widgets-<?php echo esc_attr( $layout ) ?>">
		<div class="container">
			<div class="row">

				<?php
				for ( $i = 1; $i <= $colums[$layout]; $i++ ) {
					$column_class = 12 / $colums[$layout];

					if ( '4-columns' == $layout ) {
						$column_class = in_array( $i, array(1, 4) ) ? 4 : 2;
					}

					echo '<div class="footer-widgets-area-' . esc_attr( $i ) . ' footer-widgets-area col-xs-12 col-sm-6 col-md-' . esc_attr( $column_class ) . '">';

					dynamic_sidebar( 'footer-' . $i );

					echo '</div>';
				}
				?>

			</div>
		</div>
	</div>

	<?php
	deux_in_preview( '</div>' );
}

add_action( 'deux_footer', 'deux_footer_widgets', 6 );

/**
 * Display Instagram feed on footer
 */
function deux_footer_instagram() {
	deux_in_preview( '<div class="el-customize-footer-instagram">' );

	if ( ! deux_get_option( 'footer_instagram' )) {
		return;
	}
    ?>
      <div class="footer-instagram">
      <h5>
        <?php esc_html_e( '@ Instagram', 'deux' ); ?>
      </h5>
        <?php echo deux_shortcode_tag_exists('instagram-feed'); ?>
      </div>
    <?php 
    deux_in_preview( '</div>' );
}

add_action( 'deux_content_after', 'deux_footer_instagram', 999 );

/**
 *  Display site footer
 */
function deux_footer_info() {
	$social_extra  = deux_get_option( 'footer_social_extra' );
	$wrapper       = deux_get_option( 'footer_wrapper' );
	$wrapper_class = 'wrapped' == $wrapper ? 'container' : 'deux-container';
	?>
	<div class="footer-info footer-<?php echo esc_attr( $wrapper ) ?>">
		<div class="<?php echo esc_attr( $wrapper_class ); ?>">
			<div class="row">

				<div class="site-info <?php echo has_nav_menu( 'socials' ) || $social_extra ? 'col-md-6' : 'col-md-12' ?>">
					<div class="copyright">
						<?php echo do_shortcode( wp_kses_post( deux_get_option( 'footer_copyright' ) ) ); ?>
					</div><!-- .site-info -->
					<?php
					if ( has_nav_menu( 'footer' ) ) {
						wp_nav_menu( array(
							'container'       => 'nav',
							'container_class' => 'footer-menu',
							'theme_location'  => 'footer',
							'menu_id'         => 'footer-menu',
							'depth'           => 1,
						) );
					}
					?>
				</div>

				<?php if ( has_nav_menu( 'socials' ) || $social_extra ) : ?>
					<div class="footer-social col-md-6">
						<?php
						if ( has_nav_menu( 'socials' ) ) {
							wp_nav_menu( array(
								'theme_location'  => 'socials',
								'container_class' => 'socials-menu ',
								'menu_id'         => 'footer-socials',
								'depth'           => 1,
								'link_before'     => '<span>',
								'link_after'      => '</span>',
							) );
						}

						if ( $social_extra ) {
							printf( '<div class="socials-extra">%s</div>', do_shortcode( wp_kses_post( $social_extra ) ) );
						}
						?>
					</div>
				<?php endif; ?>

			</div>
		</div>
	</div>
	<?php
}

add_action( 'deux_footer', 'deux_footer_info' );

/**
 * Footer bottom content
 *
 * @since 1.1.5
 */
function deux_footer_bottom() {
	if ( ! ( $footer_bottom_content = deux_get_option( 'footer_bottom_content' ) ) ) {
		return;
	}

	printf(
		'<div class="footer-bottom text-%s"><div class="deux-container">%s</div></div>',
		esc_attr( deux_get_option( 'footer_bottom_content_align' ) ),
		do_shortcode( wp_kses_post( $footer_bottom_content ) )
	);
}

add_action( 'deux_footer', 'deux_footer_bottom', 30 );


if ( ! function_exists( 'deux_search_modal' ) ) :
	/**
	 * Add search modal to footer
	 */
	function deux_search_modal() {
		?>
		<div id="search-modal" class="search-modal deux-modal" tabindex="-1" role="dialog">
			<div class="modal-header">
				<a href="#" class="close-modal">
					<?php echo deux_get_svg_icon_html( 'close-delete' ); ?>
				</a>
			</div>

			<div class="modal-content">
				<div class="container">
					<form method="get" class="instance-search" action="<?php echo esc_url( home_url( '/' ) ); ?>">
						<div class="text-center loading">
							<i class="fa fa-circle-o-notch fa-spin fa-fw margin-bottom"></i>
						</div>
						<div class="search-fields">

							<input type="text" name="s" placeholder="<?php esc_attr_e( 'Search', 'deux' ); ?>" class="search-field" autocomplete="off">
							<input type="hidden" name="post_type" value="product">

							<button type="submit" class="search-submit">
								<?php echo deux_get_svg_icon_html( 'search' ); ?>
							</button>
						</div>
					</form>

					<div class="search-results">
						<div class="buttons">
							<span class="search-results-text">
								<span></span>
								<span class="search-label"><?php esc_html_e( 'SEARCH', 'deux' ) ?></span>
								<span><?php esc_html_e( 'Search result(s) for', 'deux' ) ?></span>
								<span></span>
							</span>
							<span class="line-hover search-reset"><?php esc_html_e( 'Reset', 'deux' ) ?></span>
							<a href="#" class="line-hover "><?php esc_html_e( 'View More', 'deux' ) ?></a>
						</div>
						<div class="clearfix"></div>
						
						<div class="woocommerce"></div>
					</div>
				</div>
			</div>
		</div>
		<?php
	}

endif;

add_action( 'wp_footer', 'deux_search_modal' );

if ( ! function_exists( 'deux_login_modal' ) ) :
	/**
	 * Add login modal to footer
	 */
	function deux_login_modal() {
		if ( ! shortcode_exists( 'woocommerce_my_account' ) ) {
			return;
		}

		if ( is_user_logged_in() ) {
			return;
		}
		?>
		<div id="login-modal" class="login-modal woocommerce-account" data-toggle="iziModal-open" tabindex="-1" role="dialog">
			<div class="login-modal-header">
				<a href="#" data-izimodal-close="" data-izimodal-transitionout="fadeOutDown" class="close-modal">
					<?php echo deux_get_svg_icon_html( 'close-delete' ); ?>
				</a>
			</div>

			<div class="login-modal-content">
					<?php echo deux_shortcode_tag_exists( 'woocommerce_my_account' ); ?>
			</div>
		</div>
		<?php
	}
endif;

add_action( 'wp_footer', 'deux_login_modal' );

if ( ! function_exists( 'deux_cart_panel' ) ) :
	/**
	 * Add cart panel to footer
	 */
	function deux_cart_panel() {
		if ( ! deux_is_woocommerce_activated() ) {
			return;
		}
		
		?>

		<div id="cart-panel" class="cart-panel side-menu side-menu--from-right woocommerce">
			<div class="cart-panel__header">
				<a href="#" class="close-cart-panel">
					<?php echo deux_get_svg_icon_html( 'close-delete' ); ?>
				</a>
                 
                <div class="counter-cart-panel">
				<?php printf( '%s <span class="count cart-counter">%s</span>', deux_shopping_cart_icon( false ), intval( WC()->cart->get_cart_contents_count() ) ) ?>
				</div>
			</div>
            
			<div class="cart-panel__content">
				<div class="accordion-item active" data-type="cart">
					
					<div class="accordion-tab">
						<span class="line-hover tab active"><?php esc_html_e( 'Carrito', 'deux' ) ?>
							<span class="count cart-counter"><?php echo intval( WC()->cart->get_cart_contents_count() ); ?></span>
							<span class="cart-subtotal">&dash; <?php echo WC()->cart->get_cart_subtotal() ?></span>
						</span>
					</div>

					<div class="accordion-content woocommerce">
						<div class="widget_shopping_cart_content">
							<?php woocommerce_mini_cart(); ?>
						</div>
					</div>
				</div>

				<?php if ( defined( 'YITH_WCWL' ) && YITH_WCWL ) : ?>
					<div class="accordion-item" data-type="wishlist">
						
						<div class="accordion-tab">
							<span class="line-hover tab"><?php esc_html_e( 'Wishlist', 'deux' ) ?>
								<span class="count wishlist-counter"><?php echo yith_wcwl_count_products() ?></span>
							</span>
						</div>

						<div class="accordion-content woocommerce-wishlist">
							<div class="wishlist-table-content">
								<?php wc_get_template( 'panel/ajax-wishlist.php' ); ?>
							</div>
						</div>
					</div>
				<?php endif; ?>
					
			</div>
		</div>
		<?php
	}
endif;

add_action( 'wp_footer', 'deux_cart_panel' );

if ( ! function_exists( 'deux_quick_view_modal' ) ) :
	/**
	 * Adds quick view modal to footer
	 */
	function deux_quick_view_modal() {
		if ( ! deux_get_option( 'product_quickview' ) ) {
			return;
		}
		?>

		<div id="quick-view-modal" class="quick-view-modal deux-modal woocommerce" tabindex="-1" role="dialog">
			<div class="modal-header">
				<a href="#" class="close-modal">
					<?php echo deux_get_svg_icon_html( 'close-delete' ); ?>
				</a>

				<h2><?php esc_html_e( 'Product Quick View', 'deux' ); ?></h2>
			</div>

			<div class="modal-content">
				<div class="container">

					<div class="deux-modal-backdrop"></div>
					<div class="product"></div>

				</div>
			</div>

			<div class="deux-modal-backdrop"></div>
			<div class="loader"></div>
		</div>

		<?php
	}
endif;

add_action( 'wp_footer', 'deux_quick_view_modal' );

/**
 * Prepare mobile nav at the footer
 */
function deux_mobile_nav() {
	$menu        = has_nav_menu( 'mobile' ) ? 'mobile' : 'primary';
	$menu_top    = deux_get_option( 'mobile_menu_top' );
	$menu_bottom = deux_get_option( 'mobile_menu_bottom' );
	$css_class   = array( 'side-menu', 'side-menu--from-left', 'mobile-menu' );

	if ( ! empty( $menu_top ) ) {
		$css_class[] = 'has-top-content';
	}

	if ( ! empty( $menu_bottom ) ) {
		$css_class[] = 'has-bottom-content';
	}
	?>

	<div class="side-menu-overlay"></div>

	<div id="mobile-menu" class="<?php echo esc_attr( implode( ' ', $css_class ) ) ?>">
		<div class="mobile-menu-inner">
			<?php if ( deux_get_option( 'mobile_menu_close' ) ) : ?>
				<span class="toggle-nav active" data-target="mobile-menu"><span class="icon-burger"></span></span>
			<?php endif; ?>

			<?php if ( ! empty( $menu_top ) ) : ?>

				<div class="mobile-menu-top clearfix">
					<?php
					foreach ( (array) $menu_top as $item ) {
						switch ( $item ) {
							case 'currency':
								deux_currency_switcher();
								break;

							case 'language':
								deux_language_switcher();
								break;
						}
					}
					?>
				</div>

			<?php endif; ?>

			<?php if ( deux_get_option( 'mobile_menu_search' ) ) : ?>
				<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ) ?>">
						<span class="screen-reader-text"><?php esc_html_e( 'Search for:', 'deux' ) ?></span>
						<input type="search" class="search-field" placeholder="<?php esc_attr_e( 'Search', 'deux' ) ?>" value="<?php get_search_query() ?>" name="s" />
					<?php if ( 'all' !== deux_get_option( 'mobile_menu_search_content' ) ) : ?>
						<input type="hidden" name="post_type" value="<?php echo esc_attr( deux_get_option( 'mobile_menu_search_content' ) ) ?>">
					<?php endif; ?>
					<button type="submit" class="search-submit">
						<span class="screen-reader-text"><?php esc_html_e( 'Search', 'deux' ) ?></span>
						<?php echo deux_get_svg_icon_html( 'search' ); ?>
					</button>
				</form>
			<?php endif; ?>

			<nav id="mobile-nav" class="mobile-nav">
				<?php wp_nav_menu( array( 'theme_location' => $menu, 'container' => false ) ); ?>
			</nav>

			<?php if ( ! empty( $menu_bottom ) && deux_is_woocommerce_activated() ) : ?>

				<div class="mobile-menu-bottom">
					<ul>
						<?php
						foreach ( (array) $menu_bottom as $item ) {
							switch ( $item ) {
								case 'cart':
									printf(
										'<li class="item-cart"><a href="%s" %s>
											%s
											<span class="count cart-counter">%s</span>
										</a></li>',
										esc_url( wc_get_cart_url() ),
										is_user_logged_in() ? '' : 'data-toggle="slide" data-target="cart-panel" data-accordion-item="cart"',
										deux_get_svg_icon_html( deux_get_option( 'shop_cart_icon' ) ) ,
										intval( WC()->cart->get_cart_contents_count() )
									);
									break;

								case 'login':						
									printf(
										'<li class="item-login"><a href="%s" %s>
											%s											
										</a></li>',
					esc_url( wc_get_account_endpoint_url( 'dashboard' ) ),
					( is_user_logged_in() ? '' : 'data-izimodal-open="#login-modal" data-izimodal-transitionin="fadeInDown"' ),
					( is_user_logged_in() ? get_avatar( get_the_author_meta( 'ID', get_current_user_id() ), 30 ) : deux_get_svg_icon_html( 'user-account-people' ) )

									);
									break;
							}
						}
						?>
					</ul>
				</div>

			<?php endif; ?>
		</div>
	</div>

	<?php
}

add_action( 'wp_footer', 'deux_mobile_nav' );

/**
 * Place primary menu on footer for header v6
 */
function deux_side_nav() {
	if ( 'v6' !== deux_get_option( 'header_layout' ) ) {
		return;
	}

	?>
	<nav id="primary-menu" class="side-menu primary-menu">
		<span class="toggle-nav active" data-target="primary-menu"><span class="icon-burger"></span></span>

		<?php wp_nav_menu( array( 'theme_location' => 'primary', 'container' => false ) ); ?>
	</nav>
	<?php
}

add_action( 'wp_footer', 'deux_side_nav' );

/**
 * Add the popup HTML to footer
 *
 * @since 2.0
 */
function deux_popup() {
	if ( ! deux_get_option( 'popup' ) ) {
		return;
	}

	$popup_frequency = intval( deux_get_option( 'popup_frequency' ) );

	if ( $popup_frequency > 0 && isset( $_COOKIE['deux_popup'] ) ) {
		return;
	}

	// $popup_layout = deux_get_option( 'popup_layout' );

	$popup_layout = 'modal';

	get_template_part( 'template-parts/popup', $popup_layout );
}

add_action( 'wp_footer', 'deux_popup' );