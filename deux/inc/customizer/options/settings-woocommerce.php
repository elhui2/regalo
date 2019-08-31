<?php
if ( deux_is_woocommerce_activated() ) {
	
	Deux_Kirki::add_section( 'shop-section', array(
		'title'    => esc_html__( 'Shop', 'deux' ),
		'priority' => 80,
		'panel'    => 'theme_options',
	) );
	
	$options['shop_page_header_bg'] = array( 
		'settings' => 'shop_page_header_bg'        ,
		'type'            => 'image',
		'label'           => esc_html__( 'Shop Page Header Image', 'deux' ),
		'description'     => esc_html__( 'The default background image for page header on shop pages', 'deux' ),
		'section'         => 'header-section',
		'default'         => '',
		'active_callback' => array(
			array(
				'setting'  => 'page_header_enable',
				'operator' => '==',
				'value'    => true,
			),
			array(
				'setting'  => 'page_header_style',
				'operator' => '==',
				'value'    => 'normal',
			),
		),
	);
	$options['shop_page_header_text_color'] = array( 
		'settings' => 'shop_page_header_text_color',
		'type'            => 'select',
		'label'           => esc_html__( 'Shop Page Header Text Color', 'deux' ),
		'section'         => 'header-section',
		'default'         => 'dark',
		'choices'         => array(
			'dark'  => esc_html__( 'Dark', 'deux' ),
			'light' => esc_html__( 'Light', 'deux' ),
		),
		'active_callback' => array(
			array(
				'setting'  => 'page_header_enable',
				'operator' => '==',
				'value'    => true,
			),
			array(
				'setting'  => 'page_header_style',
				'operator' => '!=',
				'value'    => 'minimal',
			),
		),
	);

	// Shop General
	$options['open_cart_modal_after_add'] = array( 
		'settings' => 'open_cart_modal_after_add'  ,
		'type'        => 'toggle',
		'label'       => esc_html__( 'Ajax Open Cart Panel', 'deux' ),
		'description' => esc_html__( 'Open the cart panel after successful addition', 'deux' ),
		'section'     => 'shop-section',
		'default'     => false,
	);
	$options['product_sold_out_ribbon'] = array( 
		'settings' => 'product_sold_out_ribbon'    ,
		'type'        => 'toggle',
		'label'       => esc_html__( 'Sold Out Ribbon', 'deux' ),
		'description' => esc_html__( 'Display the "Sold Out" ribbon for out of stock products', 'deux' ),
		'section'     => 'shop-section',
		'default'     => false,
	);
	$options['product_newness'] = array( 
		'settings' => 'product_newness'            ,
		'type'        => 'number',
		'label'       => esc_html__( 'Product Newness', 'deux' ),
		'description' => esc_html__( 'Display the "New" badge for how many days?', 'deux' ),
		'section'     => 'shop-section',
		'default'     => 3,
	);
	$options['product_badge_counter'] = array( 
		'settings'    => 'product_badge_counter',
		'type'        => 'toggle',
		'label'       => esc_html__( 'Shop Page Header Counter', 'deux' ),
		'description' => esc_html__( 'Display the "New" badge counter', 'deux' ),
		'section'     => 'shop-section',
		'default'     => false,
	);
	// Shop catalog
	$options['divider-catalog-product'] = array( 
		'settings'    => 'divider-catalog-product',
		'type'        => 'custom',
		'section'     => 'shop-section',
		'default'     => '<h4 class="customize-subtitle">'. esc_html__('Catalog', 'deux') .'</h4>'
	);
	$options['shop_toolbar'] = array( 
		'settings' => 'shop_toolbar'                   ,
		'type'        => 'toggle',
		'label'       => esc_html__( 'Shop Toolbar', 'deux' ),
		'description' => esc_html__( 'Enable shop toolbar on the top of catalog pages', 'deux' ),
		'section'     => 'shop-section',
		'default'     => true,
	);
	$options['products_toggle'] = array( 
		'settings' 		  => 'products_toggle',
		'type'            => 'toggle',
		'label'           => esc_html__( 'Product Tabs', 'deux' ),
		'description'     => esc_html__( 'Enable product tabs on top left', 'deux' ),
		'tooltip'		  => 'Turn this off if you want product sorting',
		'section'         => 'shop-section',
		'default'         => true,
		'active_callback' => array(
			array(
				'setting'  => 'shop_toolbar',
				'operator' => '==',
				'value'    => true,
			),
		),
	);
	$options['products_toggle_type'] = array( 
		'settings' => 'products_toggle_type'           ,
		'type'            => 'select',
		'label'           => esc_html__( 'Products Tabs Type', 'deux' ),
		'description'     => esc_html__( 'Select how to group products in tabs', 'deux' ),
		'section'         => 'shop-section',
		'default'         => 'category',
		'choices'         => array(
			'group'    => esc_html__( 'Groups', 'deux' ),
			'category' => esc_html__( 'Categories', 'deux' ),
		),
		'active_callback' => array(
			array(
				'setting'  => 'shop_toolbar',
				'operator' => '==',
				'value'    => true,
			),
			array(
				'setting'  => 'products_toggle',
				'operator' => '==',
				'value'    => true,
			),
		),
	);
	$options['products_toggle_groups'] = array( 
		'settings' => 'products_toggle_groups'         ,
		'type'            => 'multicheck',
		'label'           => esc_html__( 'Products Tab Groups', 'deux' ),
		'description'     => esc_html__( 'Select how to group products in tabs', 'deux' ),
		'section'         => 'shop-section',
		'default'         => array( 'featured', 'new', 'sale' ),
		'choices'         => array(
			'featured' => esc_html__( 'Hot Products', 'deux' ),
			'new'      => esc_html__( 'New Products', 'deux' ),
			'sale'     => esc_html__( 'Sale Products', 'deux' ),
		),
		'active_callback' => array(
			array(
				'setting'  => 'shop_toolbar',
				'operator' => '==',
				'value'    => true,
			),
			array(
				'setting'  => 'products_toggle',
				'operator' => '==',
				'value'    => true,
			),
			array(
				'setting'  => 'products_toggle_type',
				'operator' => '==',
				'value'    => 'group',
			),
		),
	);
	$options['products_toggle_category_amount'] = array( 
		'settings' => 'products_toggle_category_amount',
		'type'            => 'number',
		'label'           => esc_html__( 'Number Of Categories', 'deux' ),
		'description'     => esc_html__( 'Amount of top categories to get', 'deux' ),
		'section'         => 'shop-section',
		'default'         => 3,
		'active_callback' => array(
			array(
				'setting'  => 'shop_toolbar',
				'operator' => '==',
				'value'    => true,
			),
			array(
				'setting'  => 'products_toggle',
				'operator' => '==',
				'value'    => true,
			),
			array(
				'setting'  => 'products_toggle_type',
				'operator' => '==',
				'value'    => 'category',
			),
		),
	);
	$options['products_sorting'] = array( 
		'settings' => 'products_sorting'               ,
		'type'            => 'toggle',
		'label'           => esc_html__( 'Products Sort', 'deux' ),
		'description'     => esc_html__( 'Show the sort options instead of the product count', 'deux' ),
		'section'         => 'shop-section',
		'default'         => false,
		'active_callback' => array(
			array(
				'setting'  => 'shop_toolbar',
				'operator' => '==',
				'value'    => true,
			),
			array(
				'setting'  => 'products_toggle',
				'operator' => '!==',
				'value'    => true,
			),
		),
	);
	// $options['products_filter'] = array( 
	// 	'settings' => 'products_filter'                ,
	// 	'type'            => 'toggle',
	// 	'label'           => esc_html__( 'Products Filter', 'deux' ),
	// 	'description'     => esc_html__( 'Show filter icon on the right side', 'deux' ),
	// 	'tooltip'         => esc_html__( 'This requires Shop Filter sidebar must has at least one widget.', 'deux' ),
	// 	'section'         => 'shop-section',
	// 	'default'         => true,
	// 	'active_callback' => array(
	// 		array(
	// 			'setting'  => 'shop_toolbar',
	// 			'operator' => '==',
	// 			'value'    => true,
	// 		),
	// 	),
	// );
	$options['products_item_style'] = array( 
		'settings' => 'products_item_style'            ,
		'type'            => 'radio',
		'label'           => esc_html__( 'Product Style', 'deux' ),
		'description'     => esc_html__( 'Select the style for product in grid while hovered', 'deux' ),
		'section'         => 'shop-section',
		'default'         => 'default',
		'choices'         => array(
			'default'   => 'Default',
			'addtocart' => 'AddtoCart',
			'slider'    => 'Slider'
		),
	);

	$options['products_item_animate'] = array( 
		'settings' 		  => 'products_item_animate',
		'type'            => 'radio',
		'label'           => esc_html__( 'Product Item Animation', 'deux' ),
		'description'     => esc_html__( 'Select the animation for product in grid while scrolled', 'deux' ),
		'section'         => 'shop-section',
		'default'         => 'anim-shop',
		'choices'         => array(
			'anim-shop'   	=> 'Default',
			'fade-left' 	=> 'Fade Left',
			'fade-right'    => 'Fade Right',
			'zoom-in'		=> 'Zoom In'
		),
	);

	$options['product_hover_thumbnail'] = array( 
		'settings' => 'product_hover_thumbnail'        ,
		'type'        => 'toggle',
		'label'       => esc_html__( 'Show Hover Thumbnail', 'deux' ),
		'description' => esc_html__( 'Show different product thumbnail when hover', 'deux' ),
		'section'     => 'shop-section',
		'default'     => true,
		'active_callback' => array(
			array(
				'setting'  => 'products_item_style',
				'operator' => 'in',
				'value'    => array( 'default', 'quickview', 'addtocart' ),
			),
		),
	);
	$options['product_quickview'] = array( 
		'settings' => 'product_quickview'              ,
		'type'        => 'toggle',
		'label'       => esc_html__( 'Product Quick View', 'deux' ),
		'description' => esc_html__( 'Show the product modal when a product clicked', 'deux' ),
		'section'     => 'shop-section',
		'default'     => true,
	);
	$options['product_hide_outstock_price'] = array( 
		'settings' => 'product_hide_outstock_price'    ,
		'type'        => 'toggle',
		'label'       => esc_html__( 'Hide Out Of Stock Price', 'deux' ),
		'description' => esc_html__( 'Hide the price if a product is out of stock', 'deux' ),
		'section'     => 'shop-section',
		'default'     => false,
	);
	$options['product_columns'] = array( 
		'settings' => 'product_columns'                ,
		'type'    => 'select',
		'label'   => esc_html__( 'Product Columns', 'deux' ),
		'section' => 'shop-section',
		'default' => '5',
		'choices' => array(
			'4' => esc_html__( '4 Columns', 'deux' ),
			'5' => esc_html__( '5 Columns', 'deux' ),
			'6' => esc_html__( '6 Columns', 'deux' ),
		),
	);
	$options['products_per_page'] = array( 
		'settings' => 'products_per_page'              ,
		'type'    => 'number',
		'label'   => esc_html__( 'Products Per Page', 'deux' ),
		'section' => 'shop-section',
		'default' => 15,
	);
	$options['shop_nav_type'] = array( 
		'settings' => 'shop_nav_type'                  ,
		'type'    => 'radio',
		'label'   => esc_html__( 'Navigation Type', 'deux' ),
		'section' => 'shop-section',
		'default' => 'links',
		'choices' => array(
			'links'    => esc_html__( 'Numeric', 'deux' ),
			'ajax'     => esc_html__( 'Load more button', 'deux' ),
			'infinity' => esc_html__( 'Infinity Scroll', 'deux' ),
		),
	);
	$options['product_attribute'] = array( 
		'settings' 	  => 'product_attribute',
		'type'        => 'select',
		'label'       => esc_html__( 'Product Attribute', 'deux' ),
		'section'     => 'shop-section',
		'choices'     => deux_product_attributes(),
		'description' => esc_html__( 'Show product attribute for each item listed under the item name.', 'deux' ),
	);

	// Single Product
	$options[] = array( 
		'settings'    => 'divider-single-product',
		'type'        => 'custom',
		'section'     => 'shop-section',
		'default'     => '<h4 class="customize-subtitle">'. esc_html__('Single Product', 'deux') .'</h4>'
	);
	$options['single_product_style'] = array( 
		'settings' => 'single_product_style'   ,
		'type'    => 'select',
		'label'   => esc_html__( 'Single Product Style', 'deux' ),
		'section' => 'shop-section',
		'default' => 'style-1',
		'choices' => array(
			'style-1' => esc_html__( 'Style 1', 'deux' ),
			'style-2' => esc_html__( 'Style 2', 'deux' ),
			'style-3' => esc_html__( 'Style 3', 'deux' )
		),
	);
	$options['product_zoom'] = array(
		'settings'	  => 'product_zoom',  
		'type'        => 'toggle',
		'label'       => esc_html__( 'Product Image Zoom', 'deux' ),
		'description' => esc_html__( 'Zoom the product image when mouse hover', 'deux' ),
		'section'     => 'shop-section',
		'default'     => false,
	);
	$options['product_share'] = array( 
		'settings' => 'product_share'          ,
		'type'        => 'multicheck',
		'label'       => esc_html__( 'Product Share', 'deux' ),
		'description' => esc_html__( 'Select social media for sharing products', 'deux' ),
		'section'     => 'shop-section',
		'default'     => array( 'facebook', 'twitter', 'pinterest' ),
		'choices'     => array(
			'facebook'  => esc_html__( 'Facebook', 'deux' ),
			'twitter'   => esc_html__( 'Twitter', 'deux' ),
			'pinterest' => esc_html__( 'Pinterest', 'deux' ),
			'email'     => esc_html__( 'Email', 'deux' ),
		),
	);
	$options['product_extra_content'] = array( 
		'settings' => 'product_extra_content'  ,
		'type'        => 'textarea',
		'label'       => esc_html__( 'Extra Content', 'deux' ),
		'description' => esc_html__( 'Add extra content at the bottom of every product short description. Shortcodes and HTML are allowed.', 'deux' ),
		'section'     => 'shop-section',
		'default'     => '',
	);
	$options['enable_product_star_rating_ticker'] = array(
		'settings'    => 'enable_product_star_rating_ticker',
		'type'        => 'toggle',
		'label'       => esc_html__( 'Product Star Rating Ticker', 'deux' ),
		'description' => esc_html__( 'change star rating to ticker.', 'deux' ),
		'section'     => 'shop-section',
		'default'     => false,
	);
	$options['product_star_rating_ticker_number'] = array(
		'settings'    => 'product_star_rating_ticker_number',
		'type'        => 'number',
		'label'       => esc_html__( 'Number of Display Rating', 'deux' ),
		'description' => esc_html__( 'Number of Display Rating.', 'deux' ),
		'section'     => 'shop-section',
		'default'     => 5,
		'active_callback' => array(
				array(
					'setting'  => 'enable_product_star_rating_ticker',
					'operator' => '==',
					'value'    => true,
				),
		)
	);
	$options['enable_product_star_rating_color'] = array( 
		'settings'    => 'enable_product_star_rating_color',
		'type'        => 'toggle',
		'label'       => esc_html__( 'Enable Product Star Rating Duotone Color', 'deux' ),
		'description' => esc_html__( 'This color setting will effect on review rating and review comment.', 'deux' ),
		'section'     => 'shop-section',
		'default'     => false,
	);
    $options['product_star_rating_color_gradient'] = array(
		'settings'    => 'product_star_rating_color_gradient',
		'type'        => 'multicolor',
		'label'       => esc_html__( 'Star Rating Duotone Color', 'deux' ),
		'section'     => 'shop-section',
		'choices'     => array(
	        'start'   => esc_attr__( 'Color Start', 'deux' ),
	        'end'     => esc_attr__( 'Color End', 'deux' ),
	    ),
	    'default'     => array(
	        'start'    => '#f9d423', 
	        'end'      => '#ff4e50',
	    ),
		'active_callback' => array(
				array(
					'setting'  => 'enable_product_star_rating_color',
					'operator' => '==',
					'value'    => true,
				),
		)
	);

	$options['upsells_products_columns'] = array( 
		'settings'    => 'upsells_products_columns',
		'type'        => 'select',
		'label'       => esc_html__( 'Up-sells Products Columns', 'deux' ),
		'description' => esc_html__( 'Specify how many columns of up-sells products you want to show on single product page.', 'deux' ),
		'section'     => 'shop-section',
		'default'     => '5',
		'choices'     => array(
			'4'   => esc_html__( '4 Columns', 'deux' ),
			'5'   => esc_html__( '5 Columns', 'deux' ),
		),
	);
	$options['upsells_products_numbers'] = array( 
		'settings'    => 'upsells_products_numbers',
		'type'        => 'number',
		'label'       => esc_html__( 'Up-sells Products Numbers', 'deux' ),
		'description' => esc_html__( 'Specify how many numbers of up-sells products you want to show on single product page.', 'deux' ),
		'section'     => 'shop-section',
		'default'     => 6
	);

	$options['related_products_columns'] = array( 
		'settings'    => 'related_products_columns',
		'type'        => 'select',
		'label'       => esc_html__( 'Related Products Columns', 'deux' ),
		'description' => esc_html__( 'Specify how many columns of related products you want to show on single product page.', 'deux' ),
		'section'     => 'shop-section',
		'default'     => '5',
		'choices'     => array(
			'4'   => esc_html__( '4 Columns', 'deux' ),
			'5'   => esc_html__( '5 Columns', 'deux' ),
		),
	);
	$options['related_products_numbers'] = array( 
		'settings'    => 'related_products_numbers',
		'type'        => 'number',
		'label'       => esc_html__( 'Related Products Numbers', 'deux' ),
		'description' => esc_html__( 'Specify how many numbers of related products you want to show on single product page.', 'deux' ),
		'section'     => 'shop-section',
		'default'     => 6
	);
	
	$options[] = array( 
		'settings'    => 'divider-mobile-shop',
		'type'        => 'custom',
		'section'     => 'shop-section',
		'default'     => '<h4 class="customize-subtitle">'. esc_html__('Mobile Shop', 'deux') .'</h4>'
	);
	// Mobile
	$options['mobile_shop_add_to_cart'] = array( 
		'settings' => 'mobile_shop_add_to_cart',
		'type'        => 'toggle',
		'label'       => esc_html__( 'Show Buttons', 'deux' ),
		'description' => esc_html__( 'Show add to cart & add to wishlist buttons', 'deux' ),
		'section'     => 'shop-section',
		'default'     => false,
	);
	
}