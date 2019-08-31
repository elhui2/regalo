<?php
// Footer
$options['footer_gotop'] = array( 
	'settings' => 'footer_gotop'               ,
	'type'            => 'toggle',
	'label'           => esc_html__( 'Enable "Go To Top" Icon', 'deux' ),
	'section'         => 'footer-section',
	'default'         => true,
);
$options['footer_fixed'] = array( 
	'settings' 		  => 'footer_fixed'               ,
	'type'            => 'toggle',
	'label'           => esc_html__( 'Enable Fixed Footer', 'deux' ),
	'section'         => 'footer-section',
	'default'         => true,
);
$options['footer_content_enable'] = array( 
	'settings' => 'footer_content_enable',
	'type'        => 'toggle',
	'label'       => esc_html__( 'Enable Footer Content', 'deux' ),
	'description' => esc_html__( 'Display extra content above the footer', 'deux' ),
	'section'     => 'footer-section',
	'default'     => false,
);
$options['footer_content'] = array( 
	'settings' => 'footer_content'             ,
	'type'            => 'textarea',
	'label'           => esc_html__( 'Footer Extra Content', 'deux' ),
	'section'         => 'footer-section',
	'default'         => '',
	'active_callback' => array(
		array(
			'setting'  => 'footer_content_enable',
			'operator' => '==',
			'value'    => true,
		),
	),
);
$options['footer_widgets'] = array( 
	'settings' => 'footer_widgets'             ,
	'type'        => 'toggle',
	'label'       => esc_html__( 'Enable Footer Widgets', 'deux' ),
	'description' => esc_html__( 'Display widgets on footer', 'deux' ),
	'section'     => 'footer-section',
	'default'     => false,
	'transport'   => 'postMessage',
);
$options['footer_widgets_layout'] = array( 
	'settings' => 'footer_widgets_layout'      ,
	'type'            => 'radio-image',
	'label'           => esc_html__( 'Footer Widgets Layout', 'deux' ),
	'description'     => esc_html__( 'Select number of columns for displaying widgets', 'deux' ),
	'section'         => 'footer-section',
	'default'         => '4-columns',
	'choices'         => array(
		'2-columns'       => get_template_directory_uri() . '/assets/images/options/footer/2-columns.png',
		'3-columns'       => get_template_directory_uri() . '/assets/images/options/footer/3-columns.png',
		'4-columns-equal' => get_template_directory_uri() . '/assets/images/options/footer/4-columns-equal.png',
		'4-columns'       => get_template_directory_uri() . '/assets/images/options/footer/4-columns.png',
	),
	'transport'   => 'postMessage',
	'active_callback' => array(
		array(
			'setting'  => 'footer_widgets',
			'operator' => '==',
			'value'    => true,
		),
	),
);
$options['footer_instagram'] = array( 
	'settings' => 'footer_instagram'           ,
	'type'        => 'toggle',
	'label'       => esc_html__( 'Enable Instagram Feed', 'deux' ),
	'description' => esc_html__( 'Display Instagram pictures above footer (we are using plugin instagram feed by smash baloon )', 'deux' ),
	'section'     => 'footer-section',
	'default'     => false,
	'transport'   => 'postMessage',
);
 
$options['footer_wrapper'] = array( 
	'settings' => 'footer_wrapper'             ,
	'type'        => 'select',
	'label'       => esc_html__( 'Footer Wrapper', 'deux' ),
	'description' => esc_html__( 'Select the width of footer wrapper', 'deux' ),
	'section'     => 'footer-section',
	'default'     => 'full-width',
	'choices'     => array(
		'full-width' => esc_html__( 'Full Width', 'deux' ),
		'wrapped'    => esc_html__( 'Wrapped', 'deux' ),
	),
);
$options['footer_copyright'] = array( 
	'settings' => 'footer_copyright'           ,
	'type'        => 'textarea',
	'label'       => esc_html__( 'Footer Copyright', 'deux' ),
	'description' => esc_html__( 'Display copyright info on the left side of footer', 'deux' ),
	'section'     => 'footer-section',
	'default'     => sprintf( esc_html__( 'Copyright %1$s %2$s', 'deux' ), "&copy;", date( 'Y' ) ),
);
$options['footer_social_extra'] = array( 
	'settings' => 'footer_social_extra'        ,
	'type'        => 'textarea',
	'label'       => esc_html__( 'Footer Right Content', 'deux' ),
	'description' => esc_html__( 'Add extra content on the right side of footer', 'deux' ),
	'section'     => 'footer-section',
	'default'     => '',
);
$options['footer_bottom_content'] = array( 
	'settings' => 'footer_bottom_content'      ,
	'type'        => 'textarea',
	'label'       => esc_html__( 'Footer Bottom Content', 'deux' ),
	'description' => esc_html__( 'Add extra content at the bottom of footer', 'deux' ),
	'section'     => 'footer-section',
	'default'     => '',
);
$options['footer_bottom_content_align'] = array( 
	'settings' => 'footer_bottom_content_align',
	'type'    => 'select',
	'label'   => esc_html__( 'Footer Bottom Content Alignment', 'deux' ),
	'section' => 'footer-section',
	'default' => 'center',
	'choices' => array(
		'left'   => esc_html__( 'Left', 'deux' ),
		'center' => esc_html__( 'Center', 'deux' ),
		'right'  => esc_html__( 'Right', 'deux' ),
	),
);