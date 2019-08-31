<?php
// Typography body
$options['typo_body'] = array( 
	'settings' => 'typo_body'      ,
	'type'        => 'typography',
	'label'       => esc_html__( 'Body', 'deux' ),
	'description' => esc_html__( 'Customize the body font', 'deux' ),
	'section'     => 'typography-section',
	'default'     => array(
		'font-family' => 'Montserrat',
		'variant'     => 'regular',
		'font-size'   => '16px',
		'line-height' => '2.14286',
		'color'       => '#777b79',
	),
	'output'   => array(
		array(
			'element' => 'body,button,input,select,textarea',
		),
	),
	'transport' => 'auto'
);
$options['typo_link'] = array( 
	'settings' => 'typo_link',
	'type'        => 'typography',
	'label'       => esc_html__( 'Link', 'deux' ),
	'description' => esc_html__( 'Customize the link color', 'deux' ),
	'section'     => 'typography-section',
	'default'     => array(
		'color' => '#1d1d1b',
	),
	'output'   => array(
		array(
			'element' => 'a',
		),
	),
	'transport' => 'auto'
);
$options['typo_link_hover'] = array( 
	'settings' => 'typo_link_hover',
	'type'        => 'typography',
	'label'       => esc_html__( 'Link Hover', 'deux' ),
	'description' => esc_html__( 'Customize the link color when hover, visited', 'deux' ),
	'section'     => 'typography-section',
	'default'     => array(
		'color' => '#111114',
	),
	'output'   => array(
		array(
			'element' => 'a:hover, a:visited',
		),
	),
	'transport' => 'auto'
);

// Typography headings
$options[] = array( 
	'settings'    => 'divider-typo-headings',
	'type'        => 'custom',
	'section'     => 'typography-section',
	'default'     => '<h4 class="customize-subtitle">'. esc_html__('Headings', 'deux') .'</h4>'
);
$options['typo_h1'] = array( 
	'settings' => 'typo_h1'        ,
	'type'        => 'typography',
	'label'       => esc_html__( 'Heading 1', 'deux' ),
	'description' => esc_html__( 'Customize the H1 font', 'deux' ),
	'section'     => 'typography-section',
	'default'     => array(
		'font-family'    => 'Montserrat',
		'variant'        => '500',
		'font-size'      => '40px',
		'line-height'    => '1.2',
		'color'          => '#1d1d1b',
		'text-transform' => 'none',
	),
	'output'   => array(
		array(
			'element' => 'h1, .h1',
		),
	),
);
$options['typo_h2'] = array( 
	'settings' => 'typo_h2'        ,
	'type'        => 'typography',
	'label'       => esc_html__( 'Heading 2', 'deux' ),
	'description' => esc_html__( 'Customize the H2 font', 'deux' ),
	'section'     => 'typography-section',
	'default'     => array(
		'font-family'    => 'Montserrat',
		'variant'        => '500',
		'font-size'      => '30px',
		'line-height'    => '1.2',
		'color'          => '#1d1d1b',
		'text-transform' => 'none',
	),
	'output'   => array(
		array(
			'element' => 'h2, .h2',
		),
	),
);
$options['typo_h3'] = array( 
	'settings' => 'typo_h3'        ,
	'type'        => 'typography',
	'label'       => esc_html__( 'Heading 3', 'deux' ),
	'description' => esc_html__( 'Customize the H3 font', 'deux' ),
	'section'     => 'typography-section',
	'default'     => array(
		'font-family'    => 'Montserrat',
		'variant'        => '500',
		'font-size'      => '20px',
		'line-height'    => '1.2',
		'color'          => '#1d1d1b',
		'text-transform' => 'none',
	),
	'output'   => array(
		array(
			'element' => 'h3, .h3',
		),
	),
);
$options['typo_h4'] = array( 
	'settings' => 'typo_h4'        ,
	'type'        => 'typography',
	'label'       => esc_html__( 'Heading 4', 'deux' ),
	'description' => esc_html__( 'Customize the H4 font', 'deux' ),
	'section'     => 'typography-section',
	'default'     => array(
		'font-family'    => 'Montserrat',
		'variant'        => '500',
		'font-size'      => '18px',
		'line-height'    => '1.2',
		'color'          => '#1d1d1b',
		'text-transform' => 'none',
	),
	'output'   => array(
		array(
			'element' => 'h4, .h4',
		),
	),
);
$options['typo_h5'] = array( 
	'settings' => 'typo_h5'        ,
	'type'        => 'typography',
	'label'       => esc_html__( 'Heading 5', 'deux' ),
	'description' => esc_html__( 'Customize the H5 font', 'deux' ),
	'section'     => 'typography-section',
	'default'     => array(
		'font-family'    => 'Montserrat',
		'variant'        => '500',
		'font-size'      => '14px',
		'line-height'    => '1.2',
		'color'          => '#1d1d1b',
		'text-transform' => 'none',
	),
	'output'   => array(
		array(
			'element' => 'h5, .h5',
		),
	),
);
$options['typo_h6'] = array( 
	'settings' => 'typo_h6'        ,
	'type'        => 'typography',
	'label'       => esc_html__( 'Heading 6', 'deux' ),
	'description' => esc_html__( 'Customize the H6 font', 'deux' ),
	'section'     => 'typography-section',
	'default'     => array(
		'font-family'    => 'Montserrat',
		'variant'        => '500',
		'font-size'      => '12px',
		'line-height'    => '1.2',
		'color'          => '#1d1d1b',
		'text-transform' => 'none',
	),
	'output'   => array(
		array(
			'element' => 'h6, .h6',
		),
	),
);
// Typography header
$options[] = array( 
	'settings'    => 'divider-typo-header',
	'type'        => 'custom',
	'section'     => 'typography-section',
	'default'     => '<h4 class="customize-subtitle">'. esc_html__('Header', 'deux') .'</h4>'
);
$options['typo_menu'] = array( 
	'settings' => 'typo_menu',
	'type'        => 'typography',
	'label'       => esc_html__( 'Menu', 'deux' ),
	'description' => esc_html__( 'Customize the menu font', 'deux' ),
	'section'     => 'typography-section',
	'default'     => array(
		'font-family'    => 'Montserrat',
		'variant'        => '500',
		'font-size'      => '14px',
		'color'          => '#1d1d1b',
		'text-transform' => 'none',
	),
	'output'   => array(
		array(
			'element' => '.nav-menu > li > a',
		),
	),
);
$options['typo_submenu'] = array( 
	'settings' => 'typo_submenu'                   ,
	'type'        => 'typography',
	'label'       => esc_html__( 'Sub-Menu', 'deux' ),
	'description' => esc_html__( 'Customize the sub-menu font', 'deux' ),
	'section'     => 'typography-section',
	'default'     => array(
		'font-family'    => 'Poppins',
		'variant'        => 'regular',
		'font-size'      => '12px',
		'line-height'    => '1.4',
		'color'          => '#909097',
		'text-transform' => 'none',
	),
	'output'   => array(
		array(
			'element' => '.nav-menu .sub-menu a',
		),
	),
);
$options['typo_toggle_menu'] = array( 
	'settings' => 'typo_toggle_menu'               ,
	'type'        => 'typography',
	'label'       => esc_html__( 'Side Menu', 'deux' ),
	'description' => esc_html__( 'Customize the menu font of side menu on header v6', 'deux' ),
	'section'     => 'typography-section',
	'default'     => array(
		'font-family'    => 'Montserrat',
		'variant'        => '600',
		'font-size'      => '12px',
		'color'          => '#1d1d1b',
		'text-transform' => 'uppercase',
	),
	'output'   => array(
		array(
			'element' => '.primary-menu.side-menu .menu > li > a',
		),
	),
);
$options['typo_toggle_submenu'] = array( 
	'settings' => 'typo_toggle_submenu'            ,
	'type'        => 'typography',
	'label'       => esc_html__( 'Side Sub-Menu', 'deux' ),
	'description' => esc_html__( 'Customize the sub-menu font of side menu', 'deux' ),
	'section'     => 'typography-section',
	'default'     => array(
		'font-family'    => 'Poppins',
		'variant'        => 'regular',
		'font-size'      => '12px',
		'line-height'    => '1.4',
		'color'          => '#909097',
		'text-transform' => 'none',
	),
	'output'   => array(
		array(
			'element' => '.primary-menu.side-menu .sub-menu li a',
		),
	),
);
// Typography page header
$options[] = array( 
	'settings'    => 'divider-typo-pageheader',
	'type'        => 'custom',
	'section'     => 'typography-section',
	'default'     => '<h4 class="customize-subtitle">'. esc_html__('Page Header', 'deux') .'</h4>'
);
$options['typo_page_header_title'] = array( 
	'settings' => 'typo_page_header_title'         ,
	'type'            => 'typography',
	'label'           => esc_html__( 'Page Header Title', 'deux' ),
	'description'     => esc_html__( 'Customize the page header title font', 'deux' ),
	'section'         => 'typography-section',
	'default'         => array(
		'font-family'    => 'ArcaMajora',
		'variant'        => '700',
		'font-size'      => '48px',
		'line-height'    => '1',
		'text-transform' => 'none',
	),
	'active_callback' => array(
		array(
			'setting'  => 'page_header_style',
			'operator' => '==',
			'value'    => 'normal',
		),
	),
	'output'   => array(
		array(
			'element' => '.page-header .page-title',
		),
	),
	'transport' => 'auto'
);
$options['typo_page_header_minimal_title'] = array( 
	'settings' => 'typo_page_header_minimal_title' ,
	'type'            => 'typography',
	'label'           => esc_html__( 'Page Header Minimal Title', 'deux' ),
	'description'     => esc_html__( 'Customize the page header title font', 'deux' ),
	'section'         => 'typography-section',
	'default'         => array(
		'font-family'    => 'ArcaMajora',
		'variant'        => '700',
		'font-size'      => '30px',
		'line-height'    => '1',
		'text-transform' => 'none',
	),
	'active_callback' => array(
		array(
			'setting'  => 'page_header_style',
			'operator' => '==',
			'value'    => 'minimal',
		),
	),
	'output'   => array(
		array(
			'element' => '.page-header-style-minimal .page-header .page-title',
		),
	),
	'transport' => 'auto'
);
$options['typo_breadcrumb'] = array( 
	'settings' => 'typo_breadcrumb'                ,
	'type'        => 'typography',
	'label'       => esc_html__( 'Breadcrumb', 'deux' ),
	'description' => esc_html__( 'Customize the breadcrumb font', 'deux' ),
	'section'     => 'typography-section',
	'default'     => array(
		'font-family'    => 'Montserrat',
		'variant'        => '600',
		'font-size'      => '14px',
		'text-transform' => 'none',
	),
	'output'   => array(
		array(
			'element' => '.woocommerce .woocommerce-breadcrumb, .breadcrumb',
		),
	),
	'transport' => 'auto'
);
// Typography widgets
$options[] = array( 
	'settings'    => 'divider-typo-widgets',
	'type'        => 'custom',
	'section'     => 'typography-section',
	'default'     => '<h4 class="customize-subtitle">'. esc_html__('Widgets', 'deux') .'</h4>'
);
$options['type_widget_title'] = array( 
	'settings' => 'type_widget_title'              ,
	'type'        => 'typography',
	'label'       => esc_html__( 'Widget Title', 'deux' ),
	'description' => esc_html__( 'Customize the widget title font', 'deux' ),
	'section'     => 'typography-section',
	'default'     => array(
		'font-family'    => 'Montserrat',
		'variant'        => '300',
		'font-size'      => '20px',
		'text-transform' => 'none',
		'color'          => '#1d1d1b',
	),
	'output'   => array(
		array(
			'element' => '.widget-title',
		),
	),
	'transport' => 'auto'
);
// Typography product
$options[] = array( 
	'settings'    => 'divider-typo-product',
	'type'        => 'custom',
	'section'     => 'typography-section',
	'default'     => '<h4 class="customize-subtitle">'. esc_html__('Product', 'deux') .'</h4>'
);
$options['type_product_title'] = array( 
	'settings' => 'type_product_title'             ,
	'type'        => 'typography',
	'label'       => esc_html__( 'Product Name', 'deux' ),
	'description' => esc_html__( 'Customize the product name font on single product page', 'deux' ),
	'section'     => 'typography-section',
	'default'     => array(
		'font-family'    => 'ArcaMajora',
		'variant'        => '700',
		'font-size'      => '32px',
		'text-transform' => 'none',
		'color'          => '#1e1e23',
	),
	'output'   => array(
		array(
			'element' => '.woocommerce div.product .product_title',
		),
	),
);
$options['type_product_excerpt'] = array( 
	'settings' => 'type_product_excerpt'           ,
	'type'        => 'typography',
	'label'       => esc_html__( 'Product Short Description', 'deux' ),
	'description' => esc_html__( 'Customize the product short description font on single product page', 'deux' ),
	'section'     => 'typography-section',
	'default'     => array(
		'font-family'    => 'Montserrat',
		'variant'        => 'regular',
		'font-size'      => '15px',
		'line-height'    => '2',
		'text-transform' => 'none',
	),
	'output'   => array(
		array(
			'element' => '.woocommerce div.product .woocommerce-product-details__short-description, .woocommerce div.product div[itemprop="description"]',
		),
	),
);
$options['typo_woocommerce_headers'] = array( 
	'settings' => 'typo_woocommerce_headers'       ,
	'type'        => 'typography',
	'label'       => esc_html__( 'Section Titles', 'deux' ),
	'description' => esc_html__( 'Customize the font of upsell, related section title', 'deux' ),
	'section'     => 'typography-section',
	'default'     => array(
		'font-family' => 'Montserrat',
		'variant'     => 'regular',
		'font-size'   => '24px',
		'color'       => '#1d1d1b',
	),
	'output'   => array(
		array(
			'element' => '.woocommerce .upsells h2, .woocommerce .related h2, .woocommerce .recently-view h2, .woocommerce.product-style-3 div.product .product-overview-title, .woocommerce-cart .cross-sells h2',
		),
	),
);
// Typography footer
$options[] = array( 
	'settings'    => 'divider-typo-Footer',
	'type'        => 'custom',
	'section'     => 'typography-section',
	'default'     => '<h4 class="customize-subtitle">'. esc_html__('Footer', 'deux') .'</h4>'
);
$options['type_footer_info'] = array( 
	'settings' => 'type_footer_info'               ,
	'type'        => 'typography',
	'label'       => esc_html__( 'Footer Info', 'deux' ),
	'description' => esc_html__( 'Customize the font of footer menu and text', 'deux' ),
	'section'     => 'typography-section',
	'default'     => array(
		'font-family' => 'Montserrat',
		'variant'     => 'regular',
		'font-size'   => '12px',
	),
	'output'   => array(
		array(
			'element' => '.footer-info',
		),
	),
	'transport' => 'auto'
);