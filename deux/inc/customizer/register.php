<?php

defined( 'ABSPATH' ) ||	exit;

Deux_Kirki::add_config( 'deux', array(
	'option_type' => 'theme_mod',
	'capability'  => 'edit_theme_options',
) );

Deux_Kirki::add_panel( 'theme_options', array(
	'priority' => 5,
	'title'    => esc_html__( 'Theme Options', 'deux' ),
) );

Deux_Kirki::add_section( 'general-section', array(
		'title'    => esc_html__( 'General', 'deux' ),
		'priority' => 50,
		'panel'    => 'theme_options'
	) );

Deux_Kirki::add_section( 'scheme-section', array(
		'title'    => esc_html__( 'Color Scheme', 'deux' ),
		'priority' => 55,
		'panel'    => 'theme_options'
	) );

Deux_Kirki::add_section( 'typography-section', array(
		'title'    => esc_html__( 'Typography', 'deux' ),
		'priority' => 60,
		'panel'    => 'theme_options'
	) );

Deux_Kirki::add_section( 'header-section', array(
		'title'    => esc_html__( 'Header', 'deux' ),
		'priority' => 65,
		'panel'    => 'theme_options'
	) );

Deux_Kirki::add_section( 'mobile_menu-section', array(
		'title'    => esc_html__( 'Header On Mobile', 'deux' ),
		'panel'    => 'theme_options',
		'priority' => 70,
	) );

Deux_Kirki::add_section( 'blog-section', array(
		'title'    => esc_html__( 'Blog', 'deux' ),
		'priority' => 75,
		'panel'    => 'theme_options'
	) );

Deux_Kirki::add_section( 'footer-section', array(
		'title'    => esc_html__( 'Footer', 'deux' ),
		'priority' => 100,
		'panel'    => 'theme_options'
	) );

$options  = array();

$file_options = array(
	'general',
	'typography',
	'header',
	'blog',
	'footer',
	'woocommerce',
);

foreach ( $file_options as $name ) {
	$file = get_template_directory() . '/inc/customizer/options/settings-' . $name . '.php';
	if ( is_readable( $file ) ) {
		require $file;
	}
}

foreach ( $options as $option ) {
	Deux_Kirki::add_field( 'deux', $option );
}