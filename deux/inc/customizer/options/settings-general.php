<?php
// Preloader
$options['page_transition'] = array(
       'settings' 	 => 'page_transition',
       'type'     	 => 'toggle',
       'label'    	 => esc_html__( 'Enable Page Transition', 'deux' ),
	   'description' => esc_html__( 'Show a waiting screen when page is loading', 'deux' ),
       'section'  	 => 'general-section',
       'default'  	 => true
);
$options['data_loader_styles'] = array(
       'settings' => 'data_loader_styles',
       'type'     => 'select',
       'label'    => esc_attr__( 'Loader Styles', 'deux' ),
       'section'  => 'general-section',
       'description' => esc_html__( 'Loading Styles of the Animation. Eg. Pulse. Choose from 1-14 options', 'deux' ),
       'default'  => 12, 
       'choices' => array( 1 => 'Bounce', 2 => 'Flipper', 3 => 'Double Bounce', 4 => 'Rect', 5 => 'Cube', 6 => 'Scaler', 7 => 'Grid Pulse', 8 => 'Clip Rotate', 9 => 'Ball Rotate', 10 => 'Zig-Zag', 11 => 'Triangle', 12 => 'Ball Scale', 13 => 'Ball Pulse', 14 => 'Ripple' ),
       'active_callback' => array(
			array(
				'setting'  => 'page_transition',
				'operator' => '==',
				'value'    => true,
			),
		),
);
$options['data_loader_color'] = array(
       'settings' => 'data_loader_color',
       'type'     => 'color',
       'label'    => esc_html__( 'Loader Color', 'deux' ),
       'section'  => 'general-section',
       'default'  => '#ff7a5f',
       'active_callback' => array(
				array(
					'setting'  => 'page_transition',
					'operator' => '==',
					'value'    => true,
				),
			),
);
// Popup
$options['popup'] = array( 
	'settings' => 'popup',
	'type'        => 'toggle',
	'label'       => esc_html__( 'Enable Popup', 'deux' ),
	'description' => esc_html__( 'Show a popup after website loaded.', 'deux' ),
	'section'     => 'general-section',
	'default'     => false,
);
// $options['popup_layout'] = array( 
// 	'settings' => 'popup_layout',
// 	'type'            => 'radio-image',
// 	'label'           => esc_html__( 'Popup Layout', 'deux' ),
// 	'description'     => esc_html__( 'Select the popup layout', 'deux' ),
// 	'section'         => 'general-section',
// 	'default'         => 'modal',
// 	'choices'         => array(
// 		'fullscreen' => get_template_directory_uri() . '/assets/images/options/popup/popup-1.jpg',
// 		'modal'      => get_template_directory_uri() . '/assets/images/options/popup/popup-2.jpg',
// 	),
// 	'active_callback' => array(
// 		array(
// 			'setting'  => 'popup',
// 			'operator' => '==',
// 			'value'    => true,
// 		),
// 	),
// );
$options['popup_overlay_color'] = array( 
	'settings' => 'popup_overlay_color'       ,
	'type'            => 'color',
	'label'           => esc_html__( 'Overlay Color', 'deux' ),
	'description'     => esc_html__( 'Pickup the background color for popup overlay', 'deux' ),
	'section'         => 'general-section',
	'default'         => 'rgba(35,35,44,0.5)',
	'choices' 		  => array( 'alpha' => true ),
	'active_callback' => array(
		array(
			'setting'  => 'popup',
			'operator' => '==',
			'value'    => true,
		),
	),
);
$options['popup_image'] = array( 
	'settings' => 'popup_image'               ,
	'type'            => 'image',
	'label'           => esc_html__( 'Banner Image', 'deux' ),
	'description'     => esc_html__( 'Upload popup banner image', 'deux' ),
	'section'         => 'general-section',
	'active_callback' => array(
		array(
			'setting'  => 'popup',
			'operator' => '==',
			'value'    => true,
		),
		array(
			'setting'  => 'popup_layout',
			'operator' => '==',
			'value'    => 'modal',
		),
	),
);
$options['popup_content'] = array( 
	'settings' => 'popup_content'             ,
	'type'            => 'textarea',
	'label'           => esc_html__( 'Popup Content', 'deux' ),
	'description'     => esc_html__( 'Enter popup content. HTML and shortcodes are allowed.', 'deux' ),
	'section'         => 'general-section',
	'active_callback' => array(
		array(
			'setting'  => 'popup',
			'operator' => '==',
			'value'    => true,
		),
	),
);
$options['popup_frequency'] = array( 
	'settings' => 'popup_frequency'           ,
	'type'            => 'number',
	'label'           => esc_html__( 'Frequency', 'deux' ),
	'description'     => esc_html__( 'Do NOT show the popup to the same visitor again until this much day has passed.', 'deux' ),
	'section'         => 'general-section',
	'default'         => 1,
	'choices'         => array(
		'min'  => 0,
		'step' => 1,
	),
	'active_callback' => array(
		array(
			'setting'  => 'popup',
			'operator' => '==',
			'value'    => true,
		),
	),
);
$options['popup_visible'] = array( 
	'settings' => 'popup_visible'             ,
	'type'            => 'select',
	'label'           => esc_html__( 'Popup Visible', 'deux' ),
	'description'     => esc_html__( 'Select when the popup appear', 'deux' ),
	'section'         => 'general-section',
	'default'         => 'loaded',
	'choices'         => array(
		'loaded' => esc_html__( 'Right after page loads', 'deux' ),
		'delay'  => esc_html__( 'Wait for seconds', 'deux' ),
	),
	'active_callback' => array(
		array(
			'setting'  => 'popup',
			'operator' => '==',
			'value'    => true,
		),
	),
);
$options['popup_visible_delay'] = array( 
	'settings' => 'popup_visible_delay'       ,
	'type'            => 'number',
	'label'           => esc_html__( 'Delay Time', 'deux' ),
	'description'     => esc_html__( 'Set how many seconds after the page loads before the popup is displayed.', 'deux' ),
	'section'         => 'general-section',
	'default'         => 5,
	'choices'         => array(
		'min'  => 0,
		'step' => 1,
	),
	'active_callback' => array(
		array(
			'setting'  => 'popup',
			'operator' => '==',
			'value'    => true,
		),
		array(
			'setting'  => 'popup_visible',
			'operator' => '==',
			'value'    => 'delay',
		),
	),
);
// Background
$options['404_bg'] = array( 
	'settings'    => '404_bg',
	'type'        => 'image',
	'label'       => esc_html__( '404 Page', 'deux' ),
	'description' => esc_html__( 'Background image for not found page', 'deux' ),
	'section'     => 'general-section',
	'default'     => '',
);
// 404 Content
$options['404_custom_content'] = array( 
	'settings'    => '404_custom_content',
	'type'        => 'textarea',
	'label'       => esc_html__( '404 Page custom content', 'deux' ),
	'description' => esc_html__( 'for the best custom content using shortcode.', 'deux' ),
	'section'     => 'general-section',
	'default'     => '',
);
// Layout
$options[] = array( 
	'settings'    => 'divider-layouts',
	'type'        => 'custom',
	'section'     => 'general-section',
	'default'     => '<h4 class="customize-subtitle">'. esc_html__('Layouts', 'deux') .'</h4>'
);
$options['layout_default'] = array( 
	'settings' => 'layout_default',
	'type'        => 'radio-image',
	'label'       => esc_html__( 'Default Layout', 'deux' ),
	'description' => esc_html__( 'Default layout of blog and other pages', 'deux' ),
	'section'     => 'general-section',
	'default'     => 'single-right',
	'choices'     => Deux_Frontend_View::layout_types(),
);
$options['layout_post'] = array( 
	'settings' => 'layout_post'   ,
	'type'        => 'radio-image',
	'label'       => esc_html__( 'Post Layout', 'deux' ),
	'description' => esc_html__( 'Default layout of single post', 'deux' ),
	'section'     => 'general-section',
	'default'     => 'no-sidebar',
	'choices'     => Deux_Frontend_View::layout_types(),
);
$options['layout_page'] = array( 
	'settings' => 'layout_page'   ,
	'type'        => 'radio-image',
	'label'       => esc_html__( 'Page Layout', 'deux' ),
	'description' => esc_html__( 'Default layout of pages', 'deux' ),
	'section'     => 'general-section',
	'default'     => 'no-sidebar',
	'choices'     => Deux_Frontend_View::layout_types(),
);
$options['layout_shop'] = array( 
	'settings' => 'layout_shop'   ,
	'type'        => 'radio-image',
	'label'       => esc_html__( 'Shop Layout', 'deux' ),
	'description' => esc_html__( 'Default layout of shop pages', 'deux' ),
	'section'     => 'general-section',
	'default'     => 'no-sidebar',
	'choices'     => Deux_Frontend_View::layout_types(),
);

// Color Scheme
$options['base_color_scheme'] = array(
	'type' 		=> 'radio',
	'settings' 	=> 'base_color_scheme',
	'label'     => esc_html__( 'Base Color', 'deux' ),
	'section'   => 'scheme-section',
	'default'   => '_palette',
	'choices'   => array(
		'_palette'  => esc_html__( 'Palette', 'deux' ),
		'_custom'   => esc_html__( 'Custom', 'deux' ),
	),
);

$options['predefined_color_scheme'] = array(
	'type'        => 'color-palette',
	'settings'    => 'predefined_color_scheme',
	'description' => esc_attr__( 'Predefined palette color scheme.', 'deux' ),
	'label'       => esc_html__( 'Palette', 'deux' ),
	'section'     => 'scheme-section',
	'active_callback' => array(
		array(
			'setting'  => 'base_color_scheme',
			'operator' => '==',
			'value'    => '_palette',
		),
	),
	'default'     => '#FF7A5F',
	'choices'     => array(
		'colors' => array(
			'#AACA97',
			'#00A28A',
			'#C0D725',
			'#f4CE73',
			'#6EA2D5',
			'#3267AD',
			'#FF7A5F',
			'#EB3C27',
			'#C55D35',
			'#E09A3F',
		),
		'style'  => 'round',
	)
);

$options['predefined_color_scheme_custom'] = array( 
	'settings' => 'predefined_color_scheme_custom',
	'type'     => 'color',
	'label'    => esc_html__( 'Custom', 'deux' ),
	'section'  => 'scheme-section',
	'default'  => '#FF7A5F',
	'description' => esc_html__( 'Predefined custom color scheme', 'deux' ),
	'active_callback' => array(
		array(
			'setting'  => 'base_color_scheme',
			'operator' => '==',
			'value'    => '_custom',
		),
	),
);