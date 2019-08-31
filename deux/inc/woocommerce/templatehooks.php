<?php
/**
 * Customize WooCommerce templates
 *
 * @package Deux
 */

/**
 * Class for all WooCommerce template modification
 *
 * @version 1.0
 */
class Deux_WooCommerce_TemplateHooks {
	/**
	 * The single instance of the class
	 *
	 * @var deux_WooCommerce
	 */
	protected static $instance = null;

	/**
	 * Number of days to keep set a product as a new one
	 * @var int
	 */
	protected $new_duration;

	/**
	 * Main instance
	 *
	 * @return deux_WooCommerce
	 */
	public static function init() {
		if ( null == self::$instance ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	/**
	 * Construction function
	 */
	public function __construct() {
	
		$this->parse_query();
		$this->hooks();

		// Need an early hook to ajaxify update mini shop cart
		add_filter( 'woocommerce_add_to_cart_fragments', array( $this, 'add_to_cart_fragments' ) );

		// Update wishlist fragment
		Deux_Http_Ajaxmanager::register_obj( $this, 'add_to_wishlist_fragments' );
		add_action( 'wp', array( $this, 'maybe_set_wishlist_cookies' ), 99 );

		// Disable redirect to product page while having only one search result
		add_filter( 'woocommerce_redirect_single_search_result', '__return_false' );
	}

	/**
	 * Parse request to change the shop columns and products per page
	 */
	public function parse_query() {
		if ( isset( $_GET['shop_columns'] ) && in_array( intval( $_GET['shop_columns'] ), array( 4, 5, 6 ) ) ) {
			wc_setcookie( 'product_columns', intval( $_GET['shop_columns'] ), 6 * 60 * 24 * 30 );
			WC()->session->set( 'product_columns', intval( $_GET['shop_columns'] ) );
		}
	}

	/**
	 * Hooks to WooCommerce actions, filters
	 *
	 * @since  1.0
	 * @return void
	 */
	public function hooks() {

		add_action( 'pre_get_posts', array( $this, 'get_products_by_group' ) );

		$this->new_duration = deux_get_option( 'product_newness' );

		// WooCommerce Styles Don't use style from WooCommerce
		add_filter( 'woocommerce_enqueue_styles', array( $this, 'wc_styles' ) );

		// Changes gallery image size prop.
		add_filter( 'woocommerce_gallery_image_size', array( $this, 'gallery_image_size' ) );

		// Change message content
		add_filter( 'wc_add_to_cart_message_html', array( $this, 'add_to_cart_message' ) );

		// Add Bootstrap classes
		add_filter( 'post_class', array( $this, 'product_class' ), 50, 3 );
		add_filter( 'product_cat_class', array( $this, 'product_cat_class' ), 50 );

		// Change shop columns
		add_filter( 'loop_shop_columns', array( $this, 'shop_columns' ), 20 );
		add_filter( 'loop_shop_per_page', array( $this, 'products_per_page' ), 20 );

		// Add badges
		remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_show_product_loop_sale_flash' );
		remove_action( 'woocommerce_before_single_product_summary', 'woocommerce_show_product_sale_flash' );
		add_action( 'woocommerce_before_shop_loop_item_title', array( $this, 'product_ribbons' ), 15 );
		add_action( 'woocommerce_before_single_product_summary', array( $this, 'product_ribbons' ), 7 );

		// Wrap product thumbnail
		add_action( 'woocommerce_before_shop_loop_item', array( $this, 'open_loop_thumbnail_wrapper' ), 5 );
		add_action( 'woocommerce_before_shop_loop_item_title', array( $this, 'close_loop_thumbnail_wrapper' ), 30 );

		// aos item
		add_action( 'woocommerce_before_shop_loop_item', array( $this, 'aos_div_before' ), 0 );
		add_action( 'woocommerce_after_shop_loop_item', array( $this, 'aos_div_after' ), 999 );		

		// Change product link position
		if ( 'slider' == deux_get_option( 'products_item_style' ) ) {
			remove_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10 );
			remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5 );
			remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10 );

			add_action( 'woocommerce_before_shop_loop_item', array( $this, 'product_loop_thumbnail_images' ), 7 );
		} else {
			remove_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10 );
			add_action( 'woocommerce_before_shop_loop_item', array( $this, 'product_loop_link_open' ), 10 );
			remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5 );
			add_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_link_close', 20 );
		}

		remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart' );
		add_action( 'woocommerce_before_shop_loop_item_title', array( $this, 'show_product_loop_buttons' ), 25 );

		// Adds hovered thumbnail to loop product
		add_action( 'woocommerce_before_shop_loop_item_title', array( $this, 'show_product_loop_hover_thumbnail' ) );

		// Add link to product title in shop loop
		remove_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title' );
		add_action( 'woocommerce_shop_loop_item_title', array( $this, 'show_product_loop_title' ) );

		// Remove stars in shop loop
		remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );

		// Change next and prev icon
		add_filter( 'woocommerce_pagination_args', array( $this, 'pagination_args' ) );

		// Add toolbars for shop page
		add_filter( 'woocommerce_show_page_title', '__return_false' );
		remove_action( 'woocommerce_before_shop_loop', 'woocommerce_result_count', 20 );
		remove_action( 'woocommerce_before_shop_loop', 'woocommerce_catalog_ordering', 30 );
        add_action( 'woocommerce_before_shop_loop', array( $this, 'shop_filter' ) );
		add_action( 'woocommerce_before_shop_loop', array( $this, 'shop_toolbar' ) );
        add_action( 'woocommerce_before_shop_loop', array( $this, 'ajax_loading_icon' ) );

		// Remove breadcrumb, use theme's instead
		add_filter( 'woocommerce_breadcrumb_defaults', array( $this, 'breadcrumb_args' ) );
		remove_action( 'woocommerce_before_main_content', 'woocommerce_breadcrumb', 20 );

		if ( deux_get_option( 'product_hide_outstock_price' ) ) {
			add_filter( 'woocommerce_get_price_html', array( $this, 'price_html' ), 10, 2 );
		}

		/**
		 * Single products hooks
		 */
		$reorder_product_toolbar = array( 'woocommerce_before_single', 5 );
        if( in_array( deux_get_option( 'single_product_style' ), array('style-1', 'style-2') ) ){
        	$reorder_product_toolbar = array( 'woocommerce_single', 1 );

			// Reorder product meta
			remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_meta', 40 );
			add_action( 'woocommerce_after_single_product_summary', 'woocommerce_template_single_meta', 11 );
        }

        // Adds breadcrumb and product navigation on top of product
        add_action( "{$reorder_product_toolbar[0]}_product_summary", 
        				array( $this, 'product_toolbar' ), 
        					$reorder_product_toolbar[1] );

		// Wrap images and summary into a div
		add_action( 'woocommerce_before_single_product_summary', array( $this, 'open_product_summary' ), 5 );
		add_action( 'woocommerce_after_single_product_summary', array( $this, 'close_product_summary' ), 5 );

		// Remove thumbnails of product style 1, 3 & 4
		if( 'style-2' != deux_get_option( 'single_product_style' ) ) {
			remove_action( 'woocommerce_product_thumbnails', 'woocommerce_show_product_thumbnails', 20 );
		}

		// Change thumbnail size
		add_filter( 'single_product_small_thumbnail_size', array( $this, 'small_thumbnail_size' ) );

		add_action( 'wp_head', array( $this, 'override_single_product_style_3' ) );

		// Reorder description
		remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 20 );
		add_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_excerpt', 10 );

		// Add to wishlist button
		add_action( 'woocommerce_after_add_to_cart_button', array( $this, 'single_product_wishlist_button' ) );
		add_filter( 'woocommerce_reset_variations_link', array( $this, 'reset_variations_link' ) );

		// Product share
		add_action( 'woocommerce_share', array( $this, 'share' ) );

		// Product extra content
		add_action( 'woocommerce_single_product_summary', array( $this, 'product_extra_content' ), 200 );

		// Change product tabs title
		add_filter( 'woocommerce_product_tabs', array( $this, 'product_tabs' ), 50 );
		add_filter( 'woocommerce_product_tabs', array( $this, 'add_custom_tabs' ) );

		// Remove tab heading
		add_filter( 'woocommerce_product_additional_information_heading', '__return_false' );
		add_filter( 'woocommerce_product_description_heading', '__return_false' );

		// Related and upsells columns

		add_filter( 'woocommerce_output_related_products_args', array( $this, 'related_products_args' ) );
		add_filter( 'woocommerce_upsell_display_args', array( $this, 'upsell_products_args' ) );

		add_filter( 'woocommerce_dropdown_variation_attribute_options_args', array( $this, 'dropdown_variation_options_args' ) );

		/**
		 * Cart page
		 */
		remove_action( 'woocommerce_cart_collaterals', 'woocommerce_cross_sell_display' );
		add_action( 'woocommerce_after_cart', 'woocommerce_cross_sell_display' );
		add_filter( 'woocommerce_cross_sells_columns', array( $this, 'cross_sell_columns' ) );

		// Add billing title
		add_action( 'woocommerce_checkout_before_customer_details', array( $this, 'billing_title' ) );

		/**
		 * Cart widget
		 */
		remove_action( 'woocommerce_widget_shopping_cart_buttons', 'woocommerce_widget_shopping_cart_button_view_cart', 10 );
		remove_action( 'woocommerce_widget_shopping_cart_buttons', 'woocommerce_widget_shopping_cart_proceed_to_checkout', 20 );

		add_action( 'woocommerce_widget_shopping_cart_buttons', array( $this, 'widget_shopping_cart_button_view_cart' ), 10 );
		add_action( 'woocommerce_widget_shopping_cart_buttons', array( $this, 'widget_shopping_cart_button_checkout' ), 20 );

		/**
		 * Loop attribute
		 */
		add_action( 'woocommerce_after_shop_loop_item', array( $this, 'variationsAttribute' ), 4 );
		
	}

	/**
	 * Override template single product 3, passing to wp_head
	 */
	public function override_single_product_style_3() {
		if ( 'style-3' == deux_get_option( 'single_product_style' ) ) {			

			// Wrap
			add_action( 'woocommerce_after_single_product_summary', array( $this, 'after_single_product_3_summary_before'), 5 );
			
			add_action( 'woocommerce_after_single_product_summary', array( $this, 'after_single_product_3_summary_middle'), 7 );

			add_action( 'woocommerce_after_single_product_summary', array( $this, 'after_single_product_3_summary_after'), 11 );

			add_action( 'woocommerce_after_single_product_summary', 'woocommerce_template_single_excerpt', 6 );

			remove_action( 'woocommerce_single_product_summary', 'woocommerce_template_single_sharing', 50 );
			add_action( 'woocommerce_after_single_product_summary', 'woocommerce_template_single_sharing', 6 );

			add_action( 'woocommerce_after_single_product_summary', array( $this, 'after_single_product_3_summary_content'), 14 );

		}
	}

	function after_single_product_3_summary_before(){
		printf( '<div class="product-overview">
					<h2 class="product-overview-title">%s</h2>
					<div class="row">
					<div class="col-sm-6 col-lg-6">', esc_html( 'Overview', 'deux' ) );
	}

	function after_single_product_3_summary_middle(){
		echo '</div><div class="col-sm-6 col-lg-6 product-overview-info">'; 
	}

	function after_single_product_3_summary_after(){
		echo '</div></div></div>';
	}

	function after_single_product_3_summary_content(){
		echo '<div class="product-description">';
			the_content(); 
		echo '</div>';
	}
	

	/**
	 * Remove default woocommerce styles
	 *
	 * @since  1.0
	 *
	 * @param  array $styles
	 *
	 * @return array
	 */
	function wc_styles( $styles ) {
		array_splice( $styles, 0, 2 ); return $styles;
	}

	/**
	 * Change gallery image size.
	 *
	 * @return string
	 */
	public function gallery_image_size() {
		return 'woocommerce_single';
	}

	/**
	 * Move the button to the end of message
	 *
	 * @param string $message
	 *
	 * @return string
	 */
	public function add_to_cart_message( $message ) {
		if ( preg_match( '/(<a\b[^>]*>(.*?)<\/a>)/i', $message, $matches ) ) {
			$message = preg_replace( '/<a\b[^>]*>(.*?)<\/a>/i', '', $message );
			$message .= $matches[0];
		}

		return $message;
	}

	/**
	 * Ajaxify update cart viewer
	 *
	 * @since 1.0
	 *
	 * @param array $fragments
	 *
	 * @return array
	 */
	public function add_to_cart_fragments( $fragments ) {

		$fragments['span.cart-counter'] = '<span class="count cart-counter">' . WC()->cart->get_cart_contents_count() . '</span>';
		$fragments['span.cart-subtotal'] = '<span class="cart-subtotal">&dash; ' . WC()->cart->get_cart_subtotal() . '</span>';
        $fragments['span.cart-counter--mobile'] = sprintf( '<span class="count cart-counter--mobile %s"></span>', deux_is_cart_empty( 'cart_empty' ) );

		return $fragments;
	}

	/**
	 * Ajaxify update wishlist viewer
	 *
	 * @param $fragments
	 *
	 * @return mixed
	 */
	public function add_to_wishlist_fragments() {
		if ( ! function_exists('wc_setcookie') || ! function_exists( 'YITH_WCWL' ) ) {
			return;
		}

		$products = YITH_WCWL()->get_products( array(
			'is_default' => true
		) );

		ob_start();

		wc_get_template( 'panel/ajax-wishlist.php' );

		$content_wishlist = ob_get_clean();

		$empty_wishlist = ( (int) yith_wcwl_count_products() == 0 ) ? 'wishlist_empty' : '';

		$data = array(
			'wishlist' => array(
					'span.wishlist-counter' => '<span class="count wishlist-counter">' . (int) yith_wcwl_count_products() . '</span>',
					'span.wishlist-counter--mobile' => sprintf('<span class="count wishlist-counter--mobile %s"></span>', $empty_wishlist ),
					'.wishlist-table-content' => '<div class="wishlist-table-content">'. $content_wishlist . '</div>'
				),
			'wishlist_hash' =>  md5( json_encode( $products ) )
		);

		wp_send_json( $data );
	}

	
	function maybe_set_wishlist_cookies() {
		if(! function_exists('wc_setcookie') || ! function_exists('YITH_WCWL') ) return;
		$products = YITH_WCWL()->get_products( array(
			'is_default' => true
		) );

		if ( ! headers_sent() && did_action( 'wp_loaded' ) ) {
			if ( ! empty( $products ) ) {
				$this->_set_wishlist_cookies( true );
			} elseif ( isset( $_COOKIE['deux_items_in_wishlist'] ) ) {
				$this->_set_wishlist_cookies( false );
			}
		}
	}

	
	private function _set_wishlist_cookies( $set = true ) {
		if(! function_exists('wc_setcookie') || ! function_exists('YITH_WCWL') ) return;
		$products = YITH_WCWL()->get_products( array(
			'is_default' => true
		) );
		if ( $set ) {
			wc_setcookie( 'deux_items_in_wishlist', 1 );
			wc_setcookie( 'deux_wishlist_hash', md5( json_encode( $products ) ) );
		} elseif ( isset( $_COOKIE['deux_items_in_wishlist'] ) ) {
			wc_setcookie( 'deux_items_in_wishlist', 0, time() - HOUR_IN_SECONDS );
			wc_setcookie( 'deux_wishlist_hash', '', time() - HOUR_IN_SECONDS );
		}
		do_action( 'deux_set_wishlist_cookies', $set );
	}

	/**
	 * Change the shop columns
	 *
	 * @since  1.0.0
	 *
	 * @param  int $columns The default columns
	 *
	 * @return int
	 */
	public function shop_columns( $columns ) {
		if ( is_woocommerce() ) {
			$columns = ! is_null( WC()->session->get( 'product_columns' ) ) ? intval( WC()->session->get( 'product_columns' ) ) : intval( deux_get_option( 'product_columns' ) );
		}

		return $columns;
	}

	/**
	 * Change number of products per page
	 *
	 * @param int $limit
	 *
	 * @return int
	 */
	public function products_per_page( $limit ) {
		if ( is_woocommerce() ) {
			$limit = intval( deux_get_option( 'products_per_page' ) );

			if ( ! is_null( WC()->session->get( 'product_columns' ) ) ) {
				$limit = 3 * intval( WC()->session->get( 'product_columns' ) );
			}
		}

		return $limit;
	}

	/**
	 * Change next and previous icon of pagination nav
	 *
	 * @since  1.0
	 */
	public function pagination_args( $args ) {
		$args['prev_text'] =  deux_get_svg_icon_html( 'left-arrow' );
		$args['next_text'] =  deux_get_svg_icon_html( 'right-arrow' );

		if ( deux_get_option( 'shop_nav_type' ) != 'links' ) {
			$loading           = '<span class="loading-icon">
			<span class="bubble"><span class="dot"><span class="dot__color dot__color--1"></span></span></span>
			<span class="bubble"><span class="dot"><span class="dot__color dot__color--2"></span></span></span>
			<span class="bubble"><span class="dot"><span class="dot__color dot__color--3"></span></span></span></span>';
			$args['prev_text'] = '';
			$args['next_text'] = '<span class="button-text"><span class="bubble">
									<span class="dot"></span> 
								</span>
								<span class="bubble">
									<span class="dot"></span> 
								</span>
								<span class="bubble">
									<span class="dot"></span> 
								</span></span>' . $loading;
		}

		return $args;
	}

	/**
	 * Shop filter
	 */
	public function shop_filter() {
		if ( is_active_sidebar( 'shop-filter' ) && deux_get_option( 'products_filter' ) ) : ?>
			<div class="filter-widgets woocommerce">
			<?php dynamic_sidebar( 'shop-filter' ); ?>
			</div>
		<?php endif;
	}

	/**
	 * Change the main query to get products by group
	 *
	 * @param object $query
	 */
	public function get_products_by_group( $query ) {
		if ( is_admin() || empty( $_GET['product_group'] ) || ! is_woocommerce() || ! $query->is_main_query() ) {
			return;
		}

		switch ( $_GET['product_group'] ) {
			case 'featured':
				if( version_compare( WC()->version, '3.0.0', '<' ) ) {
					$meta_query = WC()->query->get_meta_query();
					$meta_query[] = array(
						'key'   => '_featured',
						'value' => 'yes',
					);
					$query->set( 'meta_query', $meta_query );
				} else {
					$tax_query = WC()->query->get_tax_query();
					$tax_query[] = array(
						'taxonomy' => 'product_visibility',
						'field'    => 'name',
						'terms'    => 'featured',
						'operator' => 'IN',
					);
					$query->set( 'tax_query', $tax_query );
				}
				break;

			case 'sale':
				$query->set( 'post__in', array_merge( array( 0 ), wc_get_product_ids_on_sale() ) );
				break;

			case 'new':
				$query->set( 'post__in', array_merge( array( 0 ), deux_get_new_product_ids() ) );
				break;
		}
	}

	/**
	 * Display a tool bar on top of product archive
	 *
	 * @since 1.0
	 */
	public function shop_toolbar() {
		if ( ! deux_get_option( 'shop_toolbar' ) ) {
			return;
		}

		$columns = ! is_null( WC()->session->get( 'product_columns' ) ) ? intval( WC()->session->get( 'product_columns' ) ) : intval( deux_get_option( 'product_columns' ) );
		$toggle  = deux_get_option( 'products_toggle' );
		$sort    = deux_get_option( 'products_sorting' );

		if ( $toggle ) {
			$type = deux_get_option( 'products_toggle_type' );
			$product_count = wp_count_posts( 'product' );
			$tabs = array( '<li class="active"><a href="'.esc_url( remove_query_arg( array( 'product_group' ) ) ).'">' . esc_html__( 'All', 'deux' ) . '<span class="cat-count">'.$product_count->publish.'</span></a></li>' );

			if ( 'category' == $type && ! is_product_category() ) {
				$categories = get_terms( 'product_cat', array(
					'orderby'  => 'count',
					'order'    => 'DESC',
					'number'   => intval( deux_get_option( 'products_toggle_category_amount' ) ),
				) );

				if ( $categories && ! is_wp_error( $categories ) ) {
					foreach ( $categories as $category ) {
						$tabs[] = sprintf( '<li class=""><a href="%s">%s</a><span class="cat-count">%s</span></li>', esc_url( get_term_link( $category ) ), esc_html( $category->name ), esc_html( (int) $category->count ) );
					}
				}
			} elseif ( 'group' == $type || is_product_category() ) {
				$groups = deux_get_option( 'products_toggle_groups' );
				$base_url = '';
				if ( deux_is_shop() ) {
					$base_url = wc_get_page_permalink( 'shop' );
				} elseif ( is_product_taxonomy() ) {
					$term = get_queried_object();
					$base_url = get_term_link( $term );
				}

				if ( in_array( 'featured', $groups ) ) {
					$tabs[] = '<li class=""><a href="'.esc_url( add_query_arg( array( 'product_group' => 'featured' ), $base_url ) ).'">' . esc_html__( 'Featured Products', 'deux' ) . '</a></li>';
				}

				if ( in_array( 'new', $groups ) ) {
					$tabs[] = '<li class=""><a href="'.esc_url( add_query_arg( array( 'product_group' => 'new' ), $base_url ) ).'">' . esc_html__( 'New Products', 'deux' ) . '</a></li>';
				}

				if ( in_array( 'sale', $groups ) ) {
					$tabs[] = '<li class=""><a href="'.esc_url( add_query_arg( array( 'product_group' => 'sale' ), $base_url ) ).'">' . esc_html__( 'Sales Products', 'deux' ) . '</a></li>';
				}
			}
		}
		?>

		<div class="shop-toolbar">
			<div class="row">
				<div class="col-sm-9 col-md-7 hidden-xs nav-filter">
				<?php 
					if ( $toggle ) : ?>
						<ul class="products-filter clearfix">

							<?php echo implode( "\n", $tabs ) ?>
						</ul>

					<?php else : ?>
						<?php
						if ( $sort ) {
							woocommerce_catalog_ordering();
						} else {
					    	woocommerce_result_count(); 							
						}
						?>
					<?php endif; ?>
				</div>

				<div class="col-xs-12 col-sm-3 col-md-5 controls">
					<ul class="toolbar-control">
						<li class="data product-size">
							<span class="product-size--label"><?php esc_html_e( 'Show', 'deux' ); ?></span>
							<?php 
							$size_columns = array( 
								'large'  => array( 4, 'grid-two-up' ),
								'medium' => array( 5, 'grid-three-up' ),
								'small'  => array( 6, 'grid-four-up' ) );
								 
							foreach ( $size_columns as $key => $value ) {								
								printf( 
									'<a href="%1$s" class="%2$s %3$s">
									<svg viewBox="0 0 15 15"><use xlink:href="#%4$s"></use></svg>
									</a>',
									esc_url( add_query_arg( array( 'shop_columns' => $value[0] ) ) ),
									"{$key}-size",
									( $value[0] == $columns ? 'active' : '' ),
									$value[1]
								);
							 } ?>
						</li>
					</ul>
				</div>
			</div>
		</div>

		<?php
	}

	/**
	 * Display a loading icon
	 *
	 * @since 1.0
	 */
	public function ajax_loading_icon() {
		if ( ! deux_get_option( 'shop_toolbar' ) ) {
			return;
		}

		$toggle  = deux_get_option( 'products_toggle' );
		if ( $toggle ) {

			?>
			<span class="loading-icon filter-loading-icon">
				<span class="bubble">
					<span class="dot"><span class="dot__color dot__color--1"></span></span>
				</span>
				<span class="bubble">
					<span class="dot"><span class="dot__color dot__color--2"></span></span>
				</span>
				<span class="bubble">
					<span class="dot"><span class="dot__color dot__color--3"></span></span>
				</span>
			</span>
			<?php
		}

	}
	/**
	 * Insert an opening aos div tag
	 *
	 * @since 1.0
	 */
	public function aos_div_before() {
		if ( is_product() || is_cart() ) return;
	?>
		<div class="aos-item" data-aos="<?php echo esc_attr( deux_get_option( 'products_item_animate' ) );?>" data-aos-duration="800">
	<?php 
	}
	/**
	 * Insert an closing aos div tag
	 *
	 * @since 1.0
	 */
	public function aos_div_after() {
		if ( is_product() || is_cart() ) return;
		?>
		</div>
		<?php 

	}
	/**
	 * Filter function for breadcrumb args
	 *
	 * @param array $args
	 *
	 * @return mixed
	 */
	public function breadcrumb_args( $args ) {
		$args['delimiter']   = deux_get_font_icon_html( 'fa fa-long-arrow-right' );
		$args['wrap_before'] = '<nav class="woocommerce-breadcrumb breadcrumb" ' . ( is_single() ? 'itemprop="breadcrumb"' : '' ) . '>';

		return $args;
	}

	/**
	 * Add Bootstrap's column classes for product
	 *
	 * @since 1.0
	 *
	 * @param array  $classes
	 * @param string $class
	 * @param string $post_id
	 *
	 * @return array
	 */
	public function product_class( $classes, $class = '', $post_id = '' ) {
		if ( is_admin() && ! defined( 'DOING_AJAX' ) ) {
			return $classes;
		}

		// Add classes for product
		if (
			( $this->new_duration && ( time() - ( 60 * 60 * 24 * $this->new_duration ) ) < strtotime( get_the_time( 'Y-m-d' ) ) ) || get_post_meta( $post_id, '_is_new', true )
		) {
			$classes[] = 'new';
		}

		// Add classes for products in archive page only
		if ( ! $post_id || ! in_array( get_post_type( $post_id ), array( 'product', 'product_variation' ) ) || is_single( $post_id ) ) {
			return $classes;
		}
		global $woocommerce_loop, $product;

		$classes[] = 'col-md-4 col-sm-4 col-xs-6';
        
        if( isset( $woocommerce_loop['columns'] ) ) {

			$classes[] = $woocommerce_loop['columns'] == 5 ? 'col-lg-1-5' :
			            'col-lg-' . ( 12 / $woocommerce_loop['columns'] );         	
        }

		$gallery_image_ids = method_exists( $product, 'get_gallery_image_ids' ) ? $product->get_gallery_image_ids() : $product->get_gallery_attachment_ids();
		if ( ! empty( $gallery_image_ids ) ) {
			$classes[] = 'product-has-gallery';
		}

		// Adds a class of product style in grid
		$classes[] = 'product-style-' . deux_get_option( 'products_item_style' );
		$classes[] = 'aos-item';

		return $classes;
	}

	/**
	 * Add class for product category item
	 *
	 * @param $classes
	 *
	 * @return array
	 */
	public function product_cat_class( $classes ) {
		global $woocommerce_loop, $product;

		$classes[] = 'col-md-4 col-sm-4 col-xs-6';

		if ( ! isset( $woocommerce_loop['columns'] ) ) {
			$classes[] = 'col-lg-1-5';

			return $classes;
		}

		$classes[] = $woocommerce_loop['columns'] == 5 ? 'col-lg-1-5' :
			            'col-lg-' . ( 12 / $woocommerce_loop['columns'] ); 

		return $classes;
	}

	/**
	 * Display badge for new product or featured product
	 *
	 * @since 1.0
	 */
	public function product_ribbons() {
		global $product;

		$output = array();

		if ( $product->is_on_sale() ) {
			$percentage = 0;

			if ( $product->get_type() == 'variable' ) {
				$available_variations = $product->get_available_variations();
				$max_percentage       = 0;

				for ( $i = 0; $i < count( $available_variations ); $i ++ ) {
					$variation_id        = $available_variations[ $i ]['variation_id'];
					$variable_product    = new WC_Product_Variation( $variation_id );
					$regular_price       = $variable_product->get_regular_price();
					$sales_price         = $variable_product->get_sale_price();
					$variable_percentage = $regular_price && $sales_price ? round( ( ( ( $regular_price - $sales_price ) / $regular_price ) * 100 ) ) : 0;

					if ( $variable_percentage > $max_percentage ) {
						$max_percentage = $variable_percentage;
					}
				}

				$percentage = $max_percentage ? $max_percentage : $percentage;
			} elseif ( $product->get_regular_price() != 0 ) {
				$percentage = round( ( ( $product->get_regular_price() - $product->get_sale_price() ) / $product->get_regular_price() ) * 100 );
			}

			if ( $percentage ) {
				$output[] = '<span class="onsale ribbon">' . '-' . $percentage . '%' . '</span>';
			}
		}

		if ( $product->is_featured() ) {
			$output[] = '<span class="featured ribbon">' . esc_html__( 'Hot', 'deux' ) . '</span>';
		}

		if (
			( ( time() - ( 60 * 60 * 24 * $this->new_duration ) ) < strtotime( get_the_time( 'Y-m-d' ) ) ) ||
			get_post_meta( $product->get_id(), '_is_new', true )
		) {
			$output[] = '<span class="newness ribbon">' . esc_html__( 'New', 'deux' ) . '</span>';
		}

		if ( $output ) {
			printf( '<span class="ribbons">%s</span>', implode( '', $output ) );
		}

		if ( deux_get_option( 'product_sold_out_ribbon' ) && ( ! $product->is_in_stock() && ! is_product() ) ) {
			echo '<span class="sold-out">' . esc_html__( 'Sold Out', 'deux' ) . '</span>';
		}
	}

	/**
	 * Open product thumbnail wrapper
	 */
	public function open_loop_thumbnail_wrapper() {
		echo '<div class="product-header">';
	}

	/**
	 * Close product thumbnail wrapper
	 */
	public function close_loop_thumbnail_wrapper() {
		echo '</div>';
	}

	public function product_loop_thumbnail_images() {
		global $product;

		$image_ids = method_exists( $product, 'get_gallery_image_ids' ) ? $product->get_gallery_image_ids() : $product->get_gallery_attachment_ids();

		if ( $image_ids ) {
			echo '<div class="product-images__slider owl-carousel owl-theme">';
		}

		woocommerce_template_loop_product_link_open();
		woocommerce_template_loop_product_thumbnail();
		woocommerce_template_loop_product_link_close();

		foreach ( $image_ids as $image_id ) {
			$src = wp_get_attachment_image_src( $image_id, 'shop_catalog' );

			if ( ! $src ) {
				continue;
			}

			woocommerce_template_loop_product_link_open();

			printf(
				'<img data-src="%s" width="%s" height="%s" class="owl-lazy" alt="%s">',
				esc_url( $src[0] ),
				esc_attr( $src[1] ),
				esc_attr( $src[2] ),
				esc_attr( $product->get_title() )
			);

			woocommerce_template_loop_product_link_close();
		}

		if ( $image_ids ) {
			echo '</div>';
		}
	}

	/**
	 * Open product link on the shop page
	 * Adds more attributes zooming
	 */
	public function product_loop_link_open() {
		// if ( 'zoom' == deux_get_option( 'products_item_style' ) ) {
		// 	$image = wp_get_attachment_image_src( get_post_thumbnail_id(), 'full' );

		// 	if ( $image ) {
		// 		echo '<a href="' . esc_url( get_the_permalink() ) . '" class="woocommerce-LoopProduct-link product-thumbnail-zoom" data-zoom_image="' . esc_url( $image[0] ) . '">';
		// 	} else {
		// 		woocommerce_template_loop_product_link_open();
		// 	}
		// } else {
			woocommerce_template_loop_product_link_open();
		//}
	}

	/**
	 * Add billing title
	 */
	public function billing_title() {

		$billing_title = esc_html__( 'Tus datos', 'deux' );

		if ( wc_ship_to_billing_address_only() && WC()->cart->needs_shipping() ){
			$billing_title = esc_html__( 'Billing &amp; Shipping', 'deux' );
		}

		printf( '<h3>%1$s</h3>', $billing_title );		
	}

	/**
	 * Add hover image for a product on catalog page
	 */
	public function show_product_loop_hover_thumbnail() {
		global $product;

		if ( ! deux_get_option( 'product_hover_thumbnail' ) ) {
			return;
		}

		if ( 'slider' == deux_get_option( 'products_item_style' ) ) {
			return;
		}

		$image_ids = method_exists( $product, 'get_gallery_image_ids' ) ? $product->get_gallery_image_ids() : $product->get_gallery_attachment_ids();

		if ( empty( $image_ids ) ) {
			return;
		}

		echo wp_get_attachment_image( $image_ids[0], 'shop_catalog', false, array( 'class' => 'attachment-shop_catalog size-shop_catalog product-hover-image' ) );
	}

	/**
	 * Show product buttons inside the .product-header div
	 * This contains add_to_cart and wishlist buttons
	 */
	public function show_product_loop_buttons() {
		$style              = deux_get_option( 'products_item_style' );
		$quickview          = deux_get_option( 'product_quickview' );
		?>

		<?php if ( 'default' != $style ) : ?>

			<div class="buttons-icon">
				<?php
				// Wishlist icon
				echo deux_shortcode_tag_exists( 'yith_wcwl_add_to_wishlist' );

				// Quick-view icon
				if ( $quickview ) {
					printf( '<a href="%s" class="quick_view_button button"><svg width="20" height="29"><use xlink:href="#quickview-eye"></use></svg></a>', esc_url( get_permalink() ) );
				}
				?>
			</div>

		<?php endif; ?>

		<?php if ( in_array( $style, array( 'default', 'addtocart' ) ) ) : ?>

			<div class="buttons">
				<?php
				if ( 'default' == $style && $quickview ) {
					printf( '<a href="%s" class="quick_view_button button"><svg width="20" height="29"><use xlink:href="#quickview-eye"></use></svg></a>', esc_url( get_permalink() ) );
				}

				if ( 'default' == $style ) {
					echo deux_shortcode_tag_exists( 'yith_wcwl_add_to_wishlist' );
				}

				woocommerce_template_loop_add_to_cart();
				?>
			</div>

		<?php endif; ?>

		<?php
	}

	/**
	 * Print new product title shop page with link inside
	 */
	public function show_product_loop_title() {
		?>

		<h3 class="woocommerce-loop-product__title"><a href="<?php the_permalink() ?>"><?php the_title() ?></a></h3>

		<?php
	}

	/**
	 * Hide the price for out-of-stock products
	 *
	 * @param string $price
	 * @param object $product
	 *
	 * @return string
	 */
	public function price_html( $price, $product ) {

		return ( ! $product->is_in_stock() ) ? esc_html__( 'Sold Out', 'deux' ) : $price;

	}

	/**
	 * Display product toolbar on single product page
	 */
	public function product_toolbar() {	?>

		<div class="product-toolbar">
			<?php
			the_post_navigation( array(
				'screen_reader_text' => esc_html__( 'Product navigation', 'deux' ),
				'prev_text'          => _x( '<i class="fa fa-play fa-flip-horizontal" aria-hidden="true"></i><span class="screen-reader-text">%title</span>', 'Previous post link', 'deux' ),
				'next_text'          => _x( '<span class="screen-reader-text">%title</span><i class="fa fa-play" aria-hidden="true"></i>', 'Next post link', 'deux' ),
			) );

			$yoast = get_option( 'wpseo_internallinks' );

			if ( function_exists( 'yoast_breadcrumb' ) && $yoast && $yoast['breadcrumbs-enable'] ) {
				yoast_breadcrumb( '<div class="breadcrumb">', '</div>' );
			} else {
				woocommerce_breadcrumb();
			}
			?>
		</div>

		<?php
	}

	/**
	 * Open product summary div
	 */
	public function open_product_summary() {
		echo '<div class="product-summary clearfix">';
	}

	/**
	 * Close product summary div
	 */
	public function close_product_summary() {
		echo '</div>';
	}

	/**
	 * Change thumbnail size in single product page
	 *
	 * @param string $size
	 *
	 * @return string
	 */
	public function small_thumbnail_size( $size ) {
		return $size && 'style-1' == deux_get_option( 'single_product_style' ) ? 'shop_single' : $size;
	}

	/**
	 * Add wishlist button again
	 */
	public function single_product_wishlist_button() {
		global $product;

		// Button was added to variable products manually
		if ( $product->is_type( 'variable' ) || $product->is_type( 'external' ) ) {
			return;
		}

		if( 'shortcode' === get_option('yith_wcwl_button_position') ) {
			echo deux_shortcode_tag_exists( 'yith_wcwl_add_to_wishlist' );
		}
	}

	/**
	 * Wrap reset variations link with a div container
	 *
	 * @param $link
	 *
	 * @return string
	 */
	public function reset_variations_link( $link ) {
		return '<div class="variations-reset">' . $link . '</div>';
	}

	/**
	 * Product share
	 * Share on Facebook, Twitter, Pinterest, Mail
	 */
	public function share() {
        
        if ( function_exists( 'deux_wc_share' ) ) {
			deux_wc_share( deux_get_option( 'product_share' ) );
	    }
		
	}

	/**
	 * Add extra content at bottom of product's short description
	 */
	public function product_extra_content() {
		$content = deux_get_option( 'product_extra_content' );

		if ( empty( $content ) ) {
			return;
		}

		printf( '<div class="product-extra-content">%s</div>', do_shortcode( wp_kses_post( $content ) ) );
	}

	/**
	 * Change product tab titles
	 * Add <span> to the counter beside "Review" tab
	 *
	 * @param array $tabs
	 *
	 * @return array
	 */
	public function product_tabs( $tabs ) {

		if ( 'style-3' == deux_get_option( 'single_product_style' ) ) {
			unset( $tabs['description'] );
		}

		foreach ( $tabs as &$tab ) {
			$tab['title'] = str_replace( array( '(', ')' ), array(
				'<span class="counter">',
				'</span>',
			), $tab['title'] );
		}

		return $tabs;
	}

	/**
	 * Change related products args
	 * It contains 'posts_per_page' and 'columns'
	 *
	 * @param $args
	 *
	 * @return mixed
	 */
	public function related_products_args( $args ) {

		$args['posts_per_page'] = intval( deux_get_option( 'related_products_numbers' ) );
		$args['columns']        = intval( deux_get_option( 'related_products_columns' ) );

		return $args;
	}

	/**
	 * Change upsell products args
	 * It contains 'posts_per_page' and 'columns'
	 *
	 * @param $args
	 *
	 * @return mixed
	 */
	public function upsell_products_args( $args ) {

		$args['posts_per_page'] = intval( deux_get_option( 'upsells_products_numbers' ) );
		$args['columns']        = intval( deux_get_option( 'upsells_products_columns' ) );

		return $args;
	}

	/**
	 * Change cross sell product columns
	 *
	 * @return int
	 */
	public function cross_sell_columns() {
		return 4;
	}

	/**
	 * Change the default option none text
	 *
	 * @param array $args
	 *
	 * @return array
	 */
	public function dropdown_variation_options_args( $args ) {
		$args['show_option_none'] = esc_html__( 'Select', 'deux' );

		return $args;
	}

	/**
	 * Output the proceed to checkout button.
	 */
	public function widget_shopping_cart_button_checkout() {
		?>

		<p>
			<a href="<?php echo esc_url( wc_get_checkout_url() ); ?>" class="button checkout wc-forward">
				<?php esc_html_e( 'Cotizar', 'deux' ); ?>
			</a>
		</p>

		<?php
	}

	/**
	 * Output the view cart button.
	 */
	public function widget_shopping_cart_button_view_cart() {
		?>

		<p>
			<a href="<?php echo esc_url( wc_get_cart_url() ); ?>" class="button-type-outline button cart wc-forward">
				<?php  esc_html_e( 'Carrito', 'deux' ); ?>
			</a>
		</p>

		<?php
	}

	/**
	 * output custom tab content one
	 * @return string
	 */
	public function callback_tab_content_one(){
		$content = wpautop( get_post_meta( get_the_ID(), '_custom_tab_content_one', true ) );
	    echo do_shortcode( $content );
	}

	/**
	 * output custom tab content two
	 * @return string
	 */
	public function callback_tab_content_two(){
		$content = wpautop( get_post_meta( get_the_ID(), '_custom_tab_content_two', true ) );
	    echo do_shortcode( $content );
	}

	// Adding New Tabs
	public function add_custom_tabs( $tabs = array() ) {

		if( get_post_meta( get_the_ID(), '_custom_tab_heading_one', true ) != '' ) {
			$tabs['custom_tab_one'] = array( 
				'title' => get_post_meta( get_the_ID(), '_custom_tab_heading_one', true ),
				'priority' => 25, 
				'callback' => array( $this, 'callback_tab_content_one') 
			) ;
		}


		if( get_post_meta( get_the_ID(), '_custom_tab_heading_two', true ) != '' ){
		   $tabs['custom_tab_two'] = array( 
		   		'title' => get_post_meta( get_the_ID(), '_custom_tab_heading_two', true ),
		   		'priority' => 26, 
		   		'callback' => array( $this, 'callback_tab_content_two') 
			);
		}

	   return $tabs;
	}

	/**
	 * Loop Product Attribute
	 */
	public function variationsAttribute(){
		return Deux_WooCommerce_VariationsLoopProduct::init()->Attribute();
	}

}

/**
 * Change the gallery thumbnail size.
 *
 * @param array $size Image size.
 * @return array
 */
function deux_woocommerce_gallery_thumbnail_size( $size ) {
	$size['width'] = 80;
	$size['height'] = 100;
	$size['crop'] = 1;

	return $size;
}

add_filter( 'woocommerce_get_image_size_gallery_thumbnail', 'deux_woocommerce_gallery_thumbnail_size' );