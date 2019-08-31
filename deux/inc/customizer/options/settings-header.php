<?php
// Topbar
$options['topbar_enable'] = array( 
	'settings' => 'topbar_enable'   ,
	'type'    => 'toggle',
	'label'   => esc_html__( 'Show topbar', 'deux' ),
	'section' => 'header-section',
	'default' => 0,
	'transport' => 'postMessage',
);
$options['topbar_color'] = array( 
	'settings' => 'topbar_color'    ,
	'type'     => 'radio',
	'label'    => esc_html__( 'Topbar Color', 'deux' ),
	'section'  => 'header-section',
	'default'  => 'dark',
	'priority' => 10,
	'choices'  => array(
		'dark'    => esc_html__( 'Dark', 'deux' ),
		'light'   => esc_html__( 'Light', 'deux' ),
		'vivid'   => esc_html__( 'Vivid', 'deux' ),
		'duotone' => esc_html__( 'Duotone', 'deux' ),
	),
);
$options['topbar_vivid_color'] = array( 
	'settings' => 'topbar_vivid_color',
	'type'     => 'color',
	'mode'     => 'hue',
	'label'    => esc_html__( 'Topbar Vivid Color', 'deux' ),
	'section'  => 'header-section',
	'default'  => 10,
	'active_callback' => array(
		array(
			'setting'  => 'topbar_color',
			'operator' => '==',
			'value'    => 'vivid',
		),
	),
	'output'   => array(
		array(
			'element'       => '.topbar-vivid .topbar',
			'property'      => 'background-color',
			'value_pattern' => 'hsl( $, 76%, 50% )'
		),
	),
	'transport' => 'auto'
);
$options['topbar_duotone_color'] = array( 
	'settings' => 'topbar_duotone_color',
	'type'     => 'multicolor',
	'label'    => esc_html__( 'Topbar Duotone Color', 'deux' ),
	'section'  => 'header-section',
	'choices'     => array(
	        'start'   => esc_attr__( 'Color Start', 'deux' ),
	        'end'     => esc_attr__( 'Color End', 'deux' ),
	    ),
    'default'     => array(
        'start'    => '#00dbde', 
        'end'      => '#fc00ff',
    ),
	'active_callback' => array(
		array(
			'setting'  => 'topbar_color',
			'operator' => '==',
			'value'    => 'duotone',
		),
	),
);
$options['topbar_layout'] = array( 
	'settings' => 'topbar_layout'   ,
	'type'    => 'radio',
	'label'   => esc_html__( 'Topbar Layout', 'deux' ),
	'section' => 'header-section',
	'default' => '2-columns',
	'choices' => array(
		'2-columns' => esc_html__( '2 Columns', 'deux' ),
		'1-column'  => esc_html__( '1 Column', 'deux' ),
	),
	'transport' => 'postMessage'
);
$options['topbar_left'] = array( 
	'settings' => 'topbar_left'     ,
	'type'            => 'radio',
	'label'           => esc_html__( 'Left Content', 'deux' ),
	'section'         => 'header-section',
	'default'         => 'switchers',
	'choices'         => array(
		'switchers'      => array(
			esc_html__( 'Currency and Language switchers', 'deux' ),
			esc_html__( 'It requires additional plugins installed', 'deux' ),
		),
		'custom_content' => array(
			esc_html__( 'Custom Content', 'deux' ),
			esc_html__( 'Custom content in center', 'deux' ),
		),
	),
	'active_callback' => array(
		array(
			'setting'  => 'topbar_layout',
			'operator' => '==',
			'value'    => '2-columns',
		),
	),
);
$options['topbar_content'] = array( 
	'settings' => 'topbar_content'  ,
	'type'        => 'textarea',
	'label'       => esc_html__( 'Custom Content', 'deux' ),
	'description' => esc_html__( 'Allow HTML and Shortcodes', 'deux' ),
	'section'     => 'header-section',
	'default'     => '',
	'transport' => 'postMessage'
);

// Header layout
$options[] = array( 
	'settings'    => 'divider-header-layout',
	'type'        => 'custom',
	'section'     => 'header-section',
	'default'     => '<h4 class="customize-subtitle">'. esc_html__('Header Layout', 'deux') .'</h4>'
);
$options['header_layout'] = array( 
	'settings' => 'header_layout'    ,
	'type'    => 'select',
	'label'   => esc_html__( 'Header Layout', 'deux' ),
	'section' => 'header-section',
	'default' => 'v2',
	'choices' => array(
		'v1' => esc_html__( 'Header v1', 'deux' ),
		'v2' => esc_html__( 'Header v2', 'deux' ),
		'v3' => esc_html__( 'Header v3', 'deux' ),
		'v4' => esc_html__( 'Header v4', 'deux' ),
		'v5' => esc_html__( 'Header v5', 'deux' ),
		'v6' => esc_html__( 'Header v6', 'deux' ),
	),
	'transport' => 'postMessage'
);
$options['header_wrapper'] = array( 
	'settings' => 'header_wrapper'   ,
	'type'        => 'radio',
	'label'       => esc_html__( 'Header Wrapper', 'deux' ),
	'description' => esc_html__( 'Select the width of header container', 'deux' ),
	'section'     => 'header-section',
	'default'     => 'full-width',
	'choices'     => array(
		'full-width' => esc_html__( 'Full Width', 'deux' ),
		'wrapped'    => esc_html__( 'Wrapped', 'deux' ),
	),
	'transport' => 'postMessage'
);
$options['header_bg'] = array( 
	'settings' => 'header_bg'        ,
	'type'        => 'radio',
	'label'       => esc_html__( 'Header Background', 'deux' ),
	'description' => esc_html__( 'Select header background color', 'deux' ),
	'section'     => 'header-section',
	'default'     => 'white',
	'choices'     => array(
		'white'       => esc_html__( 'White', 'deux' ),
		'transparent' => esc_html__( 'Transparent', 'deux' ),
	),
);
$options['header_text_color'] = array( 
	'settings' => 'header_text_color',
	'type'            => 'radio',
	'label'           => esc_html__( 'Header Text Color', 'deux' ),
	'description'     => esc_html__( 'Text light only apply for transparent header', 'deux' ),
	'section'         => 'header-section',
	'default'         => 'dark',
	'choices'         => array(
		'light' => esc_html__( 'Light', 'deux' ),
		'dark'  => esc_html__( 'Dark', 'deux' ),
	),
	'active_callback' => array(
		array(
			'setting'  => 'header_bg',
			'operator' => '==',
			'value'    => 'transparent',
		),
	),
);
$options['header_hover'] = array( 
	'settings' => 'header_hover'     ,
	'type'            => 'toggle',
	'label'           => esc_html__( 'Header Hover', 'deux' ),
	'description'     => esc_html__( 'Enable hover effect for transparent header', 'deux' ),
	'section'         => 'header-section',
	'default'         => true,
	'active_callback' => array(
		array(
			'setting'  => 'header_bg',
			'operator' => '==',
			'value'    => 'transparent',
		),
	),
);
$options['header_sticky'] = array( 
	'settings' => 'header_sticky'    ,
	'type'        => 'select',
	'label'       => esc_html__( 'Sticky Header', 'deux' ),
	'description' => esc_html__( 'Make header always visible on top of site', 'deux' ),
	'section'     => 'header-section',
	'default'     => 'none',
	'choices'     => array(
		'none'   => esc_html__( 'Disable', 'deux' ),
		'normal' => esc_html__( 'Normal Sticky Header', 'deux' ),
		'smart'  => esc_html__( 'Smart Sticky Header', 'deux' ),
	),
);

// Logo
$options['logo_type'] = array( 
	'settings' => 'logo_type'    ,
	'type'    => 'radio',
	'label'   => esc_html__( 'Logo Type', 'deux' ),
	'section' => 'title_tagline',
	'default' => 'text',
	'choices' => array(
		'image' => esc_html__( 'Image', 'deux' ),
		'text'  => esc_html__( 'Text', 'deux' ),
	),
	'priority' => 5,
	'transport' => 'postMessage'
);
$options['logo_font'] = array( 
	'settings' => 'logo_font'    ,
	'type'            => 'typography',
	'label'           => esc_html__( 'Logo Font', 'deux' ),
	'section'         => 'title_tagline',
	'default'         => array(
		'font-family'    => 'Poppins',
		'variant'        => '700',
		'font-size'      => '30px',
		'letter-spacing' => '0',
		'text-transform' => 'uppercase',
	),
	'output'          => array(
		array(
			'element' => '.site-branding .logo',
		),
	),
	'active_callback' => array(
		array(
			'setting'  => 'logo_type',
			'operator' => '==',
			'value'    => 'text',
		),
	),
	'transport' => 'auto'
);
$options['logo'] = array( 
	'settings' => 'logo'         ,
	'type'            => 'image',
	'label'           => esc_html__( 'Logo', 'deux' ),
	'section'         => 'title_tagline',
	'default'         => '',
	'active_callback' => array(
		array(
			'setting'  => 'logo_type',
			'operator' => '==',
			'value'    => 'image',
		),
	),
);
$options['logo_light'] = array( 
	'settings' => 'logo_light'   ,
	'type'            => 'image',
	'label'           => esc_html__( 'Logo Light', 'deux' ),
	'section'         => 'title_tagline',
	'default'         => '',
	'active_callback' => array(
		array(
			'setting'  => 'logo_type',
			'operator' => '==',
			'value'    => 'image',
		),
	),
);
$options['logo_width'] = array( 
	'settings' => 'logo_width'   ,
	'type'            => 'number',
	'label'           => esc_html__( 'Logo Width', 'deux' ),
	'section'         => 'title_tagline',
	'default'         => '',
	'active_callback' => array(
		array(
			'setting'  => 'logo_type',
			'operator' => '==',
			'value'    => 'image',
		),
	),
	'transport' => 'postMessage'
);
$options['logo_height'] = array( 
	'settings' => 'logo_height'  ,
	'type'            => 'number',
	'label'           => esc_html__( 'Logo Height', 'deux' ),
	'section'         => 'title_tagline',
	'default'         => '',
	'active_callback' => array(
		array(
			'setting'  => 'logo_type',
			'operator' => '==',
			'value'    => 'image',
		),
	),
	'transport' => 'postMessage'
);
$options['logo_position'] = array( 
	'settings' => 'logo_position',
	'type'    => 'spacing',
	'label'   => esc_html__( 'Logo Margin', 'deux' ),
	'section' => 'title_tagline',
	'default' => array(
		'top'    => '0',
		'bottom' => '0',
		'left'   => '0',
		'right'  => '0',
	),
);

// Header Icons
$options[] = array( 
	'settings'    => 'divider-header-icons',
	'type'        => 'custom',
	'section'     => 'header-section',
	'default'     => '<h4 class="customize-subtitle">'. esc_html__('Header Icons', 'deux') .'</h4>'
);
$options['header_icons'] = array( 
	'settings' => 'header_icons'              ,
	'type'            => 'sortable',
	'label'           => esc_html__( 'Header Icons', 'deux' ),
	'description'     => esc_html__( 'Select icons to display on the header', 'deux' ),
	'section'         => 'header-section',
	'default'         => array( 'search', 'login', 'cart', 'wishlist' ),
	'choices'         => array(
		'search'   => esc_html__( 'Search', 'deux' ),
		'login'    => esc_html__( 'Login', 'deux' ),
		'cart'     => esc_html__( 'Cart', 'deux' ),
		'wishlist' => esc_html__( 'Wishlist', 'deux' ),
	),
	'active_callback' => array(
		array(
			'setting'  => 'header_layout',
			'operator' => 'in',
			'value'    => array( 'v1', 'v2' ),
		),
	),
);
$options['header_icons_left'] = array( 
	'settings' => 'header_icons_left'         ,
	'type'            => 'sortable',
	'label'           => esc_html__( 'Header Icons Left', 'deux' ),
	'description'     => esc_html__( 'Select icons to display on the left side of the header', 'deux' ),
	'section'         => 'header-section',
	'default'         => array( 'search', 'login' ),
	'choices'         => array(
		'search'   => esc_html__( 'Search', 'deux' ),
		'login'    => esc_html__( 'Login', 'deux' ),
		'cart'     => esc_html__( 'Cart', 'deux' ),
		'wishlist' => esc_html__( 'Wishlist', 'deux' ),
	),
	'active_callback' => array(
		array(
			'setting'  => 'header_layout',
			'operator' => 'in',
			'value'    => array( 'v5', 'v6', 'v3' ),
		),
	),
);
$options['header_icons_right'] = array( 
	'settings' => 'header_icons_right'        ,
	'type'            => 'sortable',
	'label'           => esc_html__( 'Header Icons Right', 'deux' ),
	'description'     => esc_html__( 'Select icons to display on the right side of the header', 'deux' ),
	'section'         => 'header-section',
	'default'         => array( 'wishlist', 'cart' ),
	'choices'         => array(
		'search'   => esc_html__( 'Search', 'deux' ),
		'login'    => esc_html__( 'Login', 'deux' ),
		'cart'     => esc_html__( 'Cart', 'deux' ),
		'wishlist' => esc_html__( 'Wishlist', 'deux' ),
	),
	'active_callback' => array(
		array(
			'setting'  => 'header_layout',
			'operator' => 'in',
			'value'    => array( 'v5', 'v6', 'v3' ),
		),
	),
);
$options['header_icons_left_v4'] = array( 
	'settings' => 'header_icons_left_v4'      ,
	'type'            => 'sortable',
	'label'           => esc_html__( 'Header Icons Left V4', 'deux' ),
	'description'     => esc_html__( 'Select icons to display on the left side of the header V4', 'deux' ),
	'section'         => 'header-section',
	'default'         => array( 'search', 'login' ),
	'choices'         => array(
		'search'   => esc_html__( 'Search', 'deux' ),
		'login'    => esc_html__( 'Login', 'deux' ),
		'cart'     => esc_html__( 'Cart', 'deux' ),
		'wishlist' => esc_html__( 'Wishlist', 'deux' ),
	),
	'active_callback' => array(
		array(
			'setting'  => 'header_layout',
			'operator' => '==',
			'value'    => 'v4',
		),
	),
);
$options['header_icons_right_v4'] = array( 
	'settings' => 'header_icons_right_v4'     ,
	'type'            => 'sortable',
	'label'           => esc_html__( 'Header Icons Right V4', 'deux' ),
	'description'     => esc_html__( 'Select icons to display on the right side of the header V4', 'deux' ),
	'section'         => 'header-section',
	'default'         => array( 'wishlist', 'cart' ),
	'choices'         => array(
		'search'   => esc_html__( 'Search', 'deux' ),
		'login'    => esc_html__( 'Login', 'deux' ),
		'cart'     => esc_html__( 'Cart', 'deux' ),
		'wishlist' => esc_html__( 'Wishlist', 'deux' ),
	),
	'active_callback' => array(
		array(
			'setting'  => 'header_layout',
			'operator' => '==',
			'value'    => 'v4',
		),
	),
);
$options['shop_cart_icon_source'] = array( 
	'settings' => 'shop_cart_icon_source'     ,
	'type'    => 'radio',
	'label'   => esc_html__( 'Shopping Cart Icon Source', 'deux' ),
	'section' => 'header-section',
	'default' => 'icon',
	'choices' => array(
		'icon'  => esc_html__( 'Built-in Icon', 'deux' ),
		'image' => esc_html__( 'Upload Image', 'deux' ),
	),
);
$options['shop_cart_icon'] = array( 
	'settings' => 'shop_cart_icon'            ,
	'type'            => 'radio-image',
	'label'           => esc_html__( 'Shopping Cart Icon', 'deux' ),
	'section'         => 'header-section',
	'default'         => 'shop-cart',
	'choices'         => array(
		'shop-cart'        => get_template_directory_uri() . '/assets/images/options/carts/shop-cart.png',
		'shop-cart-1'      => get_template_directory_uri() . '/assets/images/options/carts/shop-cart-1.png',
		'shop-cart-2'      => get_template_directory_uri() . '/assets/images/options/carts/shop-cart-2.png',
		'shop-bag'         => get_template_directory_uri() . '/assets/images/options/carts/shop-bag.png',
		'shop-bag-1'       => get_template_directory_uri() . '/assets/images/options/carts/shop-bag-1.png',
		'shop-bag-2'       => get_template_directory_uri() . '/assets/images/options/carts/shop-bag-2.png',
		'shop-bag-3'       => get_template_directory_uri() . '/assets/images/options/carts/shop-bag-3.png',
		'shop-bag-4'       => get_template_directory_uri() . '/assets/images/options/carts/shop-bag-4.png',
		'shop-bag-5'       => get_template_directory_uri() . '/assets/images/options/carts/shop-bag-5.png',
		'shop-bag-6'       => get_template_directory_uri() . '/assets/images/options/carts/shop-bag-6.png',
		'shop-bag-7'       => get_template_directory_uri() . '/assets/images/options/carts/shop-bag-7.png'
	),
	'active_callback' => array(
		array(
			'setting'  => 'shop_cart_icon_source',
			'operator' => '==',
			'value'    => 'icon',
		),
	),
	'transport' => 'postMessage'
);
$options['shop_cart_icon_image'] = array( 
	'settings' => 'shop_cart_icon_image'      ,
	'type'            => 'upload',
	'label'           => esc_html__( 'Shopping Cart Icon', 'deux' ),
	'section'         => 'header-section',
	'active_callback' => array(
		array(
			'setting'  => 'shop_cart_icon_source',
			'operator' => '==',
			'value'    => 'image',
		),
	),
);
$options['shop_cart_icon_image_light'] = array( 
	'settings' => 'shop_cart_icon_image_light',
	'type'            => 'upload',
	'label'           => esc_html__( 'Shopping Cart Icon Light', 'deux' ),
	'section'         => 'header-section',
	'active_callback' => array(
		array(
			'setting'  => 'shop_cart_icon_source',
			'operator' => '==',
			'value'    => 'image',
		),
	),
);
$options['shop_cart_icon_width'] = array( 
	'settings' => 'shop_cart_icon_width'      ,
	'type'            => 'number',
	'label'           => esc_html__( 'Shopping Cart Icon Width', 'deux' ),
	'section'         => 'header-section',
	'default'         => '20',
	'active_callback' => array(
		array(
			'setting'  => 'shop_cart_icon_source',
			'operator' => '==',
			'value'    => 'image',
		),
	),
);
$options['shop_cart_icon_height'] = array( 
	'settings' => 'shop_cart_icon_height'     ,
	'type'            => 'number',
	'label'           => esc_html__( 'Shopping Cart Icon Height', 'deux' ),
	'section'         => 'header-section',
	'default'         => '20',
	'active_callback' => array(
		array(
			'setting'  => 'shop_cart_icon_source',
			'operator' => '==',
			'value'    => 'image',
		),
	),
);

$options['login_modal_image'] = array(
	'settings' 	=> 'login_modal_image',
	'type'		=> 'image',
	'label'		=> esc_html__('Login Modal Image', 'deux'),
	'section'	=> 'header-section'
);

// Page header
$options[] = array(
	'settings'    => 'divider-page-header',
	'type'        => 'custom',
	'section'     => 'header-section',
	'default'     => '<h4 class="customize-subtitle">'. esc_html__('Page Header', 'deux') .'</h4>'
);
$options['page_header_enable'] = array( 
	'settings' => 'page_header_enable'    ,
	'type'    => 'toggle',
	'label'   => esc_html__( 'Show Page Header', 'deux' ),
	'section' => 'header-section',
	'default' => 1,
);
$options['show_breadcrumb'] = array( 
	'settings' => 'show_breadcrumb'       ,
	'type'            => 'toggle',
	'label'           => esc_html__( 'Show Breadcrumb', 'deux' ),
	'section'         => 'header-section',
	'default'         => 1,
	'active_callback' => array(
		array(
			'setting'  => 'page_header_enable',
			'operator' => '==',
			'value'    => true,
		),
	),
);
$options['page_header_style'] = array( 
	'settings' => 'page_header_style'     ,
	'type'            => 'select',
	'label'           => esc_html__( 'Page Header Style', 'deux' ),
	'section'         => 'header-section',
	'default'         => 'normal',
	'choices'         => array(
		'normal'  => esc_html__( 'Normal', 'deux' ),
		'minimal' => esc_html__( 'Minimal', 'deux' ),
	),
	'active_callback' => array(
		array(
			'setting'  => 'page_header_enable',
			'operator' => '==',
			'value'    => true,
		),
	),
);
$options['page_header_parallax'] = array( 
	'settings' => 'page_header_parallax'  ,
	'type'            => 'select',
	'label'           => esc_html__( 'Page Header Parallax', 'deux' ),
	'description'     => esc_html__( 'Select header parallax animation', 'deux' ),
	'section'         => 'header-section',
	'default'         => 'none',
	'choices'         => array(
		'none' => esc_html__( 'No Parallax', 'deux' ),
		'up'   => esc_html__( 'Move Up', 'deux' ),
		'down' => esc_html__( 'Move Down', 'deux' ),
	),
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
$options['page_header_bg'] = array( 
	'settings' => 'page_header_bg'        ,
	'type'            => 'image',
	'label'           => esc_html__( 'Page Header Image', 'deux' ),
	'description'     => esc_html__( 'The default background image for page header', 'deux' ),
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
$options['page_header_text_color'] = array( 
	'settings' => 'page_header_text_color',
	'type'            => 'select',
	'label'           => esc_html__( 'Text Color', 'deux' ),
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

// Mobile Menu
$options['mobile_header_icon'] = array( 
	'settings' 	  => 'mobile_header_icon',
	'type'        => 'select',
	'label'       => esc_html__( 'Header Icon', 'deux' ),
	'description' => esc_html__( 'Select the icon you want to show on mobile header', 'deux' ),
	'section'     => 'mobile_menu-section',
	'default'     => 'cart',
	'choices'     => array(
		'cart'     => esc_html__( 'Shopping cart', 'deux' ),
		'wishlist' => esc_html__( 'Wishlist', 'deux' ),
	),
);
$options['mobile_menu_close'] = array( 
	'settings' => 'mobile_menu_close',
	'type'        => 'toggle',
	'label'       => esc_html__( 'Close Icon', 'deux' ),
	'description' => esc_html__( 'Adds a close icon on top of mobile menu', 'deux' ),
	'section'     => 'mobile_menu-section',
	'default'     => false,
);
$options['mobile_menu_width'] = array( 
	'settings' => 'mobile_menu_width'         ,
	'type'        => 'slider',
	'label'       => esc_html__( 'Mobile Menu Width', 'deux' ),
	'description' => esc_html__( 'Change mobile menu width', 'deux' ),
	'section'     => 'mobile_menu-section',
	'transport'   => 'auto',
	'default'     => 85,
	'choices'     => array(
		'min'  => '50',
		'max'  => '90',
		'step' => '1',
	),
	'output'      => array(
		array(
			'element'     => '.mobile-menu',
			'property'    => 'width',
			'units'       => '%',
			'media_query' => '@media screen and (max-width: 767px)',
		),
	),
);
$options['mobile_menu_search'] = array( 
	'settings' => 'mobile_menu_search'        ,
	'type'        => 'toggle',
	'label'       => esc_html__( 'Mobile Menu Search', 'deux' ),
	'description' => esc_html__( 'Show search form in the mobile menu', 'deux' ),
	'section'     => 'mobile_menu-section',
	'default'     => true,
);
$options['mobile_menu_search_content'] = array( 
	'settings' => 'mobile_menu_search_content',
	'type'        => 'select',
	'label'       => esc_html__( 'Search For', 'deux' ),
	'description' => esc_html__( 'Select what the search form will look for', 'deux' ),
	'section'     => 'mobile_menu-section',
	'default'     => 'all',
	'choices'     => array(
		'all'     => esc_html__( 'All content types', 'deux' ),
		'product' => esc_html__( 'Products', 'deux' ),
		'post'    => esc_html__( 'Posts', 'deux' ),
	),
);
$options['mobile_menu_top'] = array( 
	'settings' => 'mobile_menu_top'           ,
	'type'        => 'multicheck',
	'label'       => esc_html__( 'Mobile Menu Top', 'deux' ),
	'description' => esc_html__( 'Show extra items on top of the mobile menu', 'deux' ),
	'section'     => 'mobile_menu-section',
	'choices'     => array(
		'currency' => esc_html__( 'Currency Switcher (require plugin)', 'deux' ),
		'language' => esc_html__( 'Language Switcher (require plugin)', 'deux' ),
	),
);
$options['mobile_menu_bottom'] = array( 
	'settings' => 'mobile_menu_bottom'        ,
	'type'        => 'multicheck',
	'label'       => esc_html__( 'Mobile Menu Bottom', 'deux' ),
	'description' => esc_html__( 'Append items at end of the mobile menu', 'deux' ),
	'section'     => 'mobile_menu-section',
	'default'     => array( 'cart', 'login' ),
	'choices'     => array(
		'cart'  => esc_html__( 'Shopping Cart', 'deux' ),
		'login' => esc_html__( 'Login/Account', 'deux' ),
	),
);