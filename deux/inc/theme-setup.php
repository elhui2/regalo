<?php
/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function deux_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'deux_content_width', 640 );
}

add_action( 'after_setup_theme', 'deux_content_width', 0 );

if ( ! function_exists( 'deux_setup' ) ) :
	/**
	 * Sets up theme defaults and registers support for various WordPress features.
	 *
	 * Note that this function is hooked into the after_setup_theme hook, which
	 * runs before the init hook. The init hook is too late for some features, such
	 * as indicating support for post thumbnails.
	 */
	function deux_setup() {
		// Make theme available for translation.
		load_theme_textdomain( 'deux', get_template_directory() . '/languages' );

		// Add default posts and comments RSS feed links to head.
		add_theme_support( 'automatic-feed-links' );

		// Let WordPress manage the document title.
		add_theme_support( 'title-tag' );

		// Enable support for Post Thumbnails on posts and pages.
		add_theme_support( 'post-thumbnails' );

		// Supports WooCommerce plugin.
		add_theme_support( 'woocommerce', array(
			'thumbnail_image_width' => 480,
			'single_image_width' => 690,
		) );
		add_theme_support( 'wc-product-gallery-lightbox' );
		add_theme_support( 'wc-product-gallery-zoom' );

		add_theme_support( 'post-formats', array( 'gallery', 'video', 'audio' ) );

		// This theme uses wp_nav_menu() in one location.
		register_nav_menus( array(
			'primary'   => esc_html__( 'Primary Menu', 'deux' ),
			'secondary' => esc_html__( 'Secondary Menu', 'deux' ),
			'topbar'    => esc_html__( 'Topbar Menu', 'deux' ),
			'footer'    => esc_html__( 'Footer Menu', 'deux' ),
			'socials'   => esc_html__( 'Footer Socials', 'deux' ),
			'mobile'    => esc_html__( 'Mobile Menu', 'deux' ),
		) );

		/*
		 * Switch default core markup for search form, comment form, and comments
		 * to output valid HTML5.
		 */
		add_theme_support( 'html5', array(
			'search-form',
			'comment-form',
			'comment-list',
			'gallery',
			'caption',
		) );

		set_post_thumbnail_size( 100, 100, true );
		add_image_size( 'deux-blog-thumbnail', 1200, 9999, false );
		add_image_size( 'deux-blog-grid', 360, 240, true );
		add_image_size( 'deux-widget-thumbnail', 100, 100, true );
		
		// Indicate widget sidebars can use selective refresh in the Customizer.
		add_theme_support( 'customize-selective-refresh-widgets' );

		// Add support for Block Styles.
		add_theme_support( 'wp-block-styles' );

		// Add support for editor styles.
		add_theme_support( 'editor-styles' );

		// Enqueue editor styles.
		add_editor_style( array( 'css/style-editor.css' ) );

	}

endif;

add_action( 'after_setup_theme', 'deux_setup' );

/**
 * Initialize instances
 *
 * Priority 50 to make sure it run after plugin's callback, such as register custom post types...
 */
function deux_init() {
	// Check if Woocomerce plugin is actived
	if ( deux_is_woocommerce_activated() )	
		Deux_WooCommerce_TemplateHooks::init();

	if ( is_admin() ) {
		Deux_WooCommerce_SettingsGeneral::init();
		Deux_WooCommerce_SettingsTerm::init();
		Deux_WooCommerce_SettingsProduct::init();
		Deux_Nav_MegaMenuEdit::init();
	}
}

add_action( 'init', 'deux_init', 50 );

/**
 * Register widget area.
 *
 * @link https://developer.wordpress.org/themes/functionality/sidebars/#registering-a-sidebar
 */
function deux_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Blog Sidebar', 'deux' ),
		'id'            => 'blog-sidebar',
		'description'   => esc_html__( 'Add widgets here in order to display on blog', 'deux' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Page Sidebar', 'deux' ),
		'id'            => 'page-sidebar',
		'description'   => esc_html__( 'Add widgets here in order to display on pages', 'deux' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

	register_sidebar( array(
		'name'          => esc_html__( 'Shop Sidebar', 'deux' ),
		'id'            => 'shop-sidebar',
		'description'   => esc_html__( 'Add widgets here in order to display on shop pages', 'deux' ),
		'before_widget' => '<section id="%1$s" class="widget %2$s">',
		'after_widget'  => '</section>',
		'before_title'  => '<h2 class="widget-title">',
		'after_title'   => '</h2>',
	) );

	for ( $i = 1; $i < 5; $i++ ) {
		register_sidebar( array(
			'name'          => sprintf( esc_html__( 'Footer Sidebar %s', 'deux' ), $i ),
			'id'            => 'footer-' . $i,
			'description'   => esc_html__( 'Add widgets here in order to display on footer', 'deux' ),
			'before_widget' => '<div id="%1$s" class="widget %2$s">',
			'after_widget'  => '</div>',
			'before_title'  => '<h4 class="widget-title">',
			'after_title'   => '</h4>',
		) );
	}

	register_widget( 'Deux_Widgets_SocialLinks' );
	register_widget( 'Deux_Widgets_PopularPosts' );
}

add_action( 'widgets_init', 'deux_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function deux_scripts() {
	$version = wp_get_theme()->get( 'Version' );

	// Register enqueue styles
	wp_register_style( 'bootstrap', get_parent_theme_file_uri( 'assets/css/bootstrap.css' ), array(), '3.3.6' );
	wp_register_style( 'font-awesome', get_parent_theme_file_uri( 'assets/css/font-awesome.min.css' ), array(), '4.7.0' );
	wp_register_style( 'photoswipe', get_parent_theme_file_uri( 'assets/css/photoswipe.css' ), array(), '4.1.1' );
	wp_register_style( 'iziModal', get_parent_theme_file_uri( 'assets/css/iziModal.min.css' ), array(), '1.6.0' );
	wp_register_style( 'animsition', get_parent_theme_file_uri( 'assets/css/animsition.css' ), array(), '4.0.2' );
	 /* If using a child theme, auto-load the parent theme style. */
    if ( is_child_theme() ) {
        wp_enqueue_style( 'deux-style', trailingslashit( get_template_directory_uri() ) . 'style.css', array(
		'font-awesome',
		'bootstrap',
		) );
    }
    // Theme stylesheet.
	wp_enqueue_style( 'deux', get_stylesheet_uri(), array(
		'font-awesome',
		'bootstrap',
	), $version );

	// Register then enqueue scripts
	wp_register_script( 'isotope', get_parent_theme_file_uri( 'assets/js/isotope.pkgd.min.js' ), array( 'imagesloaded' ), '3.0.1', true );
	wp_register_script( 'owl-carousel', get_parent_theme_file_uri( 'assets/js/owl.carousel.min.js' ), array(), '2.2.1', true );
	wp_register_script( 'jquery-fitvids', get_parent_theme_file_uri( 'assets/js/jquery.fitvids.js' ), array(), '1.1', true );
	wp_register_script( 'theia-sticky-sidebar', get_parent_theme_file_uri( 'assets/js/theia-sticky-sidebar.min.js' ), array( 'jquery' ), '1.7.0', true );
	wp_register_script( 'easy-ticker', get_parent_theme_file_uri( 'assets/js/jquery.easy-ticker.min.js' ), array( 'jquery' ), '2.0.0', true );
	wp_register_script( 'photoswipe', get_parent_theme_file_uri( 'assets/js/photoswipe.min.js' ), array(), '4.1.1', true );
	wp_register_script( 'photoswipe-ui-default', get_parent_theme_file_uri( 'assets/js/photoswipe-ui.min.js' ), array( 'photoswipe' ), '4.1.1', true );
	wp_register_script( 'simple-scrollbar', get_parent_theme_file_uri( 'assets/js/simple-scrollbar.min.js' ), array(), '0.2.1', true );
	wp_register_script( 'headroom', get_parent_theme_file_uri( 'assets/js/headroom.min.js' ), array(), '0.9.3', true );
	wp_register_script( 'rellax', get_parent_theme_file_uri( 'assets/js/rellax.min.js' ), array( 'jquery' ), '1.0.0', true );
	wp_register_script( 'notify', get_parent_theme_file_uri( 'assets/js/notify.min.js' ), array( 'jquery' ), '0.4.2', true );
	wp_register_script( 'iziModal', get_parent_theme_file_uri( 'assets/js/iziModal.min.js' ), array( 'jquery' ), '1.5.1', true );
	wp_register_script( 'velocity', get_parent_theme_file_uri( 'assets/js/velocity.min.js' ), array( 'jquery' ), '1.5.0', true );
	wp_register_script( 'animsition', get_parent_theme_file_uri( 'assets/js/animsition.min.js' ), array( 'jquery' ), '4.0.2', true );
	wp_register_script( 'aos', get_parent_theme_file_uri( 'assets/js/aos.min.js' ), array( 'imagesloaded' ), '2.3.2', true );

	if ( deux_get_option( 'page_transition' ) ) {
		wp_enqueue_style( 'animsition' );
		wp_enqueue_script( 'animsition' );
	}

	if ( wp_script_is( 'wc-add-to-cart-variation', 'registered' ) ) {
		wp_enqueue_script( 'wc-add-to-cart-variation' );
	}


	if ( is_singular( 'product' ) && current_theme_supports( 'wc-product-gallery-lightbox' ) ) {
		wp_enqueue_script( 'photoswipe-ui-default' );
	}

	if ( is_singular( 'product' ) ) {
		$product_style = deux_get_option( 'single_product_style' );

		if ( 'style-1' == $product_style ) {
			wp_enqueue_script( 'theia-sticky-sidebar' );
		}
	}

	if ( deux_get_option( 'enable_product_star_rating_ticker' ) ) {
		wp_enqueue_script( 'easy-ticker' );
	}

	if ( 'smart' == deux_get_option( 'header_sticky' ) ) {
		wp_enqueue_script( 'headroom' );
	}

	if ( 'minimal' != deux_get_option( 'page_header_style' ) && 'none' != deux_get_option( 'page_header_parallax' ) ) {
		wp_enqueue_script( 'rellax' );
	}

	if ( deux_get_option( 'products_sorting' ) && wp_script_is( 'select2', 'registered' ) && function_exists( 'WC' ) && ( is_shop() || is_product_taxonomy() ) ) {
		wp_enqueue_style( 'select2' );
		wp_enqueue_script( 'select2' );
	}

	if ( deux_get_option( 'added_to_cart_notice' ) ) {
		wp_enqueue_script( 'notify' );
	}

	wp_enqueue_style( 'iziModal' );

    $suffix = deux_get_min_suffix();
	wp_enqueue_script( 'deux', get_template_directory_uri() . '/assets/js/script' . $suffix . '.js', array(
		'jquery',
		'isotope',
		'owl-carousel',
		'jquery-fitvids',
		'simple-scrollbar',
		'iziModal',
		'velocity',
		'aos'
	), $version, true );

	wp_localize_script( 'deux', 'deuxData', array(
		'ajax_url' 					=> esc_url( admin_url( 'admin-ajax.php' ) ),
		'sticky_header'             => deux_get_option( 'header_sticky' ),
		'shop_nav_type'             => deux_get_option( 'shop_nav_type' ),
		'page_header_parallax'      => deux_get_option( 'page_header_parallax' ),
		'open_cart_modal_after_add' => deux_get_option( 'open_cart_modal_after_add' ),
		'popup_frequency'           => deux_get_option( 'popup_frequency' ),
		'popup_visible'             => deux_get_option( 'popup_visible' ),
		'popup_visible_delay'       => deux_get_option( 'popup_visible_delay' ),
		'upsells_products_columns'  => intval( deux_get_option( 'upsells_products_columns' ) ),
		'related_products_columns'  => intval( deux_get_option( 'related_products_columns' ) ),
		'lightbox'                  => current_theme_supports( 'wc-product-gallery-lightbox' ),
		'zoom'                      => deux_get_option( 'product_zoom' ),
		'single_ajax_add_to_cart'   => get_option( 'deux_enable_single_ajax_add_to_cart' ),
		'isRTL'                     => is_rtl(),
		'l10n' => array(
			'added_to_cart_notice' => esc_html__( 'Product is added to cart successfully', 'deux' )
		),
	) );

	// Enqueue comment reply script
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}

add_action( 'wp_enqueue_scripts', 'deux_scripts' );

/**
 * Add custom image sizes attribute to enhance responsive image functionality
 * for post thumbnails
 *
 * @since Deux 1.1
 *
 * @param array $attr Attributes for the image markup.
 * @param int   $attachment Image attachment ID.
 * @param array $size Registered image size or flat array of height and width dimensions.
 * @return array The filtered attributes for the image markup.
 */
function deux_post_thumbnail_sizes_attr( $attr, $attachment, $size ) {

	if ( 'deux-blog-thumbnail' === $size ) {	
			$attr['sizes'] = ( 'no-sidebar' !== deux_get_layout() ) ?
			'(max-width: 709px) 85vw, (max-width: 909px) 67vw, (max-width: 984px) 60vw, (max-width: 1362px) 62vw, 750px' : 
			'(max-width: 709px) 85vw, (max-width: 909px) 67vw, (max-width: 1362px) 88vw, 1200px';		
	}	
	return $attr;
}

add_filter( 'wp_get_attachment_image_attributes', 'deux_post_thumbnail_sizes_attr', 10 , 3 );

/**
 * Add a walder object for all nav menu
 *
 * @since  1.0.0
 *
 * @param  array $args The default args
 *
 * @return array
 */
function deux_nav_menu_args( $args ) {
	if ( ! in_array( $args['theme_location'], array( 'topbar', 'footer', 'socials' ) ) ) {
		$args['walker'] = new Deux_Nav_MegaMenuWalker;
	}

	if ( in_array( $args['theme_location'], array( 'primary', 'secondary' ) ) ) {
		$args['fallback_cb'] = false;
	}

	return $args;
}

add_filter( 'wp_nav_menu_args', 'deux_nav_menu_args' );

/**
 * Force Visual Composer to initialize as "built into the theme".
 * remove "Design options", "Custom CSS" tabs.
 * 
 * @return void
 */
function deux_vcSetAsTheme() {

  if ( function_exists( 'vc_set_as_theme' ) ){
      vc_set_as_theme();    
  }
}
add_action( 'vc_before_init', 'deux_vcSetAsTheme' );