<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if( ! class_exists( 'OCDI_Plugin' ) ) {
	return;
}	

function deux_ocdi_plugin_title( $title ) {
	$title = '<h2>Install Demo Data</h2>';
	return $title;
}
add_filter( 'pt-ocdi/plugin_page_title', 'deux_ocdi_plugin_title' );

function deux_ocdi_plugin_intro() {
    get_template_part( 'lib/dashboard/sections/intro', 'ocdi' );
}
add_filter( 'pt-ocdi/plugin_intro_text', 'deux_ocdi_plugin_intro' );

function deux_ocdi_plugin_page_setup( $settings ) {
	return wp_parse_args( array(
	'parent_slug' => 'themes.php',
	'page_title'  =>  esc_html__( 'One Click Demo Import' , 'deux' ),
	'menu_title'  =>  esc_html__( 'Install Demo Data' , 'deux' ),
	'capability'  =>  'import',
	'menu_slug'   =>  'deux-demo-installation',
	), $settings );
}
add_filter( 'pt-ocdi/plugin_page_setup', 'deux_ocdi_plugin_page_setup' );

// Remove branding
add_filter( 'pt-ocdi/disable_pt_branding', '__return_true' );

// disable import image on customizer 
add_filter( 'pt-ocdi/customizer_import_images', '__return_false' );

// disable regenerate thumbnails while importing content
add_filter( 'pt-ocdi/regenerate_thumbnails_in_content_import', '__return_false' );

function deux_ocdi_import_files() {
	$local_path = trailingslashit( get_template_directory()  . '/lib/dummy-data' );

	return array(
		array(
			'import_file_name'             => 'Home Decor',
			'local_import_file'            => $local_path . 'homedecor/content.xml',
			'local_import_widget_file'     => $local_path . 'homedecor/widgets.wie',
			'local_import_customizer_file' => $local_path . 'homedecor/customizer.dat',
			'import_preview_image_url'   => esc_url_raw( '//qedqod.com/ocdi/deux/homedecor/preview.jpg' ),
			'preview_url'                => esc_url_raw( '//qedqod.com/demo/deux/homedecor/' ),
			'import_notice'              => esc_attr( 'After you import this demo, you will have to import the slider separately.', 'deux' ),
		),
		array(
			'import_file_name'             => 'Kitchenware',
			'local_import_file'            => $local_path . 'kitchens/content.xml',
			'local_import_widget_file'     => $local_path . 'kitchens/widgets.wie',
			'local_import_customizer_file' => $local_path . 'kitchens/customizer.dat',
			'import_preview_image_url'   => esc_url_raw( '//qedqod.com/ocdi/deux/kitchens/preview.jpg' ),	
			'preview_url'                => esc_url_raw( '//qedqod.com/demo/deux/kitchens/' ),
			'import_notice'              => esc_attr( 'After you import this demo, you will have to import the slider separately.', 'deux' ),	
		),
		array(
			'import_file_name'           => 'Lavatory',
			'local_import_file'            => $local_path . 'bath/content.xml',
			'local_import_widget_file'     => $local_path . 'bath/widgets.wie',
			'local_import_customizer_file' => $local_path . 'bath/customizer.dat',
			'import_preview_image_url'   => esc_url_raw( '//qedqod.com/ocdi/deux/bath/preview.jpg' ),	
			'preview_url'                => esc_url_raw( '//qedqod.com/demo/deux/bath/' ),		
			'import_notice'              => esc_attr( 'After you import this demo, you will have to import the slider separately.', 'deux' ),
		),
		array(
			'import_file_name'           => 'Working Space',
			'local_import_file'            => $local_path . 'office/content.xml',
			'local_import_widget_file'     => $local_path . 'office/widgets.wie',
			'local_import_customizer_file' => $local_path . 'office/customizer.dat',
			'import_preview_image_url'   => esc_url_raw( '//qedqod.com/ocdi/deux/office/preview.jpg' ),
			'preview_url'                => esc_url_raw( '//qedqod.com/demo/deux/office/' ),
			'import_notice'              => esc_attr( 'After you import this demo, you will have to import the slider separately.', 'deux' ),
		),
		array(
			'import_file_name'           => 'House Wave',
			'local_import_file'            => $local_path . 'audio-tech/content.xml',
			'local_import_widget_file'     => $local_path . 'audio-tech/widgets.wie',
			'local_import_customizer_file' => $local_path . 'audio-tech/customizer.dat',
			'import_preview_image_url'   => esc_url_raw( '//qedqod.com/ocdi/deux/audio-tech/preview.jpg' ),
			'preview_url'                => esc_url_raw( '//qedqod.com/demo/deux/audio-tech/' ),
			'import_notice'              => esc_attr( 'After you import this demo, you will have to import the slider separately.', 'deux' ),			
		),
	);
}
add_filter( 'pt-ocdi/import_files', 'deux_ocdi_import_files' );

function deux_ocdi_after_import_setup() {
    // Assign menus to their locations.
    $main_menu = get_term_by( 'name', 'Main Menu', 'nav_menu' );

    set_theme_mod( 'nav_menu_locations', array(
            'primary' => $main_menu->term_id,
        )
    );

    // Assign front page and posts page (blog page).
    $front_page_id = get_page_by_title( 'Home' );
    $blog_page_id  = get_page_by_title( 'Blog' );

     if ( $front_page_id ) {
	    update_option( 'show_on_front', 'page' );
	    update_option( 'page_on_front', $front_page_id->ID );
    }

    if ( $blog_page_id ) {
    	update_option( 'page_for_posts', $blog_page_id->ID ); 
    }

    // WooCommerce Pages
	if ( class_exists( 'WooCommerce' ) ) {
		// Shop page
		if ( ! get_option( 'woocommerce_shop_page_id' ) ) {
			$shop = get_page_by_title( 'Shop' );

			if ( $shop ) {
				update_option( 'woocommerce_shop_page_id', $shop->ID );
			}
		}

		// Cart page
		if ( ! get_option( 'woocommerce_cart_page_id' ) ) {
			$cart = get_page_by_title( 'Cart' );

			if ( $cart ) {
				update_option( 'woocommerce_cart_page_id', $cart->ID );
			}
		}

		// Checkout page
		if ( ! get_option( 'woocommerce_checkout_page_id' ) ) {
			$checkout = get_page_by_title( 'Checkout' );

			if ( $checkout ) {
				update_option( 'woocommerce_checkout_page_id', $checkout->ID );
			}
		}

		// Myaccount page
		if ( ! get_option( 'woocommerce_myaccount_page_id' ) ) {
			$account = get_page_by_title( 'My Account' );

			if ( $account ) {
				update_option( 'woocommerce_myaccount_page_id', $account->ID );
			}
		}
	}

	if ( function_exists( 'YITH_WCWL' ) ) {
		if ( ! get_option( 'yith_wcwl_button_position' ) ) {
			update_option( 'yith_wcwl_button_position', 'shortcode' );			
		}
	}

	flush_rewrite_rules();

}
add_action( 'pt-ocdi/after_import', 'deux_ocdi_after_import_setup' );