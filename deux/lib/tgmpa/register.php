<?php

if ( ! function_exists( 'deux_register_required_plugins' ) ) :
	/**
	 * Plugins List Activation   
	 * @return array
	 */
	function deux_register_required_plugins() {
		$plugins = array(
			array(
				'name'     => esc_html__( 'WooCommerce', 'deux' ),
				'slug'     => 'woocommerce',
				'required' => false,
			),
			array(
				'name'     => esc_html__( 'Meta Box', 'deux' ),
				'slug'     => 'meta-box',
				'required' => false,
			),
			array(
				'name'     => esc_html__( 'Kirki', 'deux' ),
				'slug'     => 'kirki',
				'required' => false,
			),
			array(
				'name'     => esc_html__( 'WPBakery Page Builder ( Visual Composer )', 'deux' ),
				'slug'     => 'js_composer',
				'source'   => get_template_directory() . '/lib/tgmpa/plugins/js_composer.zip',
				'version'  => '6.0.2',
				'required' => false,
			),
			array(
				'name'     => esc_html__( 'Deux Shortcodes', 'deux' ),
				'slug'     => 'deux-shortcode',
                'source'   => get_template_directory() . '/lib/tgmpa/plugins/deux-shortcode.zip', 
                'version'  => '1.0.7', 
                'required' => false,
            ),
            array(
				'name'     => esc_html__( 'Deux Portfolio', 'deux' ),
				'slug'     => 'deux-portfolio',
                'source'   => get_template_directory() . '/lib/tgmpa/plugins/deux-portfolio.zip', 
                'version'  => '1.0.0', 
                'required' => false,
            ),
			array(
				'name'     => esc_html__( 'WooCommerce Refund and Exchange', 'deux' ),
				'slug'     => 'woocommerce-refund-and-exchange',
                'source'   => get_template_directory() . '/lib/tgmpa/plugins/woocommerce-refund-and-exchange.zip',  
				'version'  => '2.1.4.1',
				'required' => false,
			),
			array(
				'name'     => esc_html__( 'Master Slider', 'deux' ),
				'slug'     => 'masterslider',
                'source'   => get_template_directory() . '/lib/tgmpa/plugins/masterslider.zip', 
                'version'  => '3.2.14', 
				'required' => false,
			),
			array(
				'name'     => esc_html__( 'WooCommerce Currency Switcher', 'deux' ),
				'slug'     => 'woocommerce-currency-switcher',
				'required' => false,
			),
			array(
				'name'     => esc_html__( 'Contact Form 7', 'deux' ),
				'slug'     => 'contact-form-7',
				'required' => false,
			),
			array(
				'name'     => esc_html__( 'Instagram Shop by Snapppt', 'deux' ),
				'slug'     => 'shop-feed-for-instagram-by-snapppt',
				'required' => false,
			),
			array(
				'name'     => esc_html__( 'MailChimp for WordPress', 'deux' ),
				'slug'     => 'mailchimp-for-wp',
				'required' => false,
			),
			array(
                'name'     => esc_html__( 'YITH WooCommerce Wishlist', 'deux' ), 
                'slug'     => 'yith-woocommerce-wishlist',
                'required' => false, 
            ),
            array(
                'name'     => esc_html__( 'YITH WooCommerce Compare', 'deux' ), 
                'slug'     => 'yith-woocommerce-compare',
                'required' => false, 
            ),
			array(
				'name'     => esc_html__( 'WooCommerce Variation Swatches', 'deux' ),
				'slug'     => 'variation-swatches-for-woocommerce',
				'required' => false,
			),
			array(
                'name'     => esc_html__( 'One Click Demo Import', 'deux' ), 
                'slug'     => 'one-click-demo-import',
                'required' => false
            ),
		);

		$config = array(
			'id'           => 'deux-plugin',
			'menu'         => 'tgmpa-install-plugins',
			'has_notices'  => true,
			'dismissable'  => true,
			'is_automatic' => true,
		);

		tgmpa( $plugins, $config );
	}

endif;
add_action( 'tgmpa_register', 'deux_register_required_plugins' );