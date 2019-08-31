<?php
// Exit if accessed directly
defined( 'ABSPATH' ) ||	exit;

/**
 * This is a short hand function for getting setting value from customizer
 *
 * @param string $name
 *
 * @return bool|string
 */
function deux_get_option( $name ) {

	return Deux_Kirki::get_option( 'deux', $name );
}

/**
 * Get product attributes
 *
 * @return string
 */
function deux_product_attributes() {
	$output = array();
	if ( function_exists( 'wc_get_attribute_taxonomies' ) ) {
		$attributes_tax = wc_get_attribute_taxonomies();
		if ( $attributes_tax ) {
			$output['none'] = esc_html__( 'None', 'deux' );

			foreach ( $attributes_tax as $attribute ) {
				$output[$attribute->attribute_name] = $attribute->attribute_label;
			}

		}
	}

	return $output;
}

/**
 * @param object $wp_customize
 */
function deux_customize_setting_transactions( $wp_customize ) {

	$wp_customize->get_setting( 'blogname' )->transport         = 'postMessage';
    $wp_customize->get_setting( 'blogdescription' )->transport  = 'postMessage';
    $wp_customize->get_control( 'blogname' )->active_callback = 'deux_customize_active_callback';
    $wp_customize->get_control( 'blogdescription' )->active_callback = 'deux_customize_active_callback';

    if ( deux_is_woocommerce_activated() ) {
	    $wp_customize->get_setting( 'woocommerce_thumbnail_cropping' )->default = 'custom';
	    $wp_customize->get_setting( 'woocommerce_thumbnail_cropping_custom_width' )->default = '3';
	    $wp_customize->get_setting( 'woocommerce_thumbnail_cropping_custom_height' )->default = '4';    	
    }

	if ( isset( $wp_customize->selective_refresh ) ) {
		
		$wp_customize->selective_refresh->add_partial( 
		'topbar_enable', array(
		    'selector' => '.el-customize-topbar',
		    'container_inclusive' => true,
		    'render_callback' => 'deux_topbar'
        ) );

		$wp_customize->selective_refresh->add_partial( 
		'topbar_layout', array(
		    'selector' => '.el-customize-topbar',
		    'container_inclusive' => true,
		    'render_callback' => 'deux_topbar'
        ) );

		$wp_customize->selective_refresh->add_partial( 
		'logo_type', array(
	    	'selector' => '.site-branding',
	    	'render_callback' => 'deux_branding_site_identity'
        ) );

        $wp_customize->selective_refresh->add_partial( 
		'header_layout', array(
		    'selector' => '.el-customize-header',
		    'container_inclusive' => true,
		    'render_callback' => 'deux_header'
        ) );

        $wp_customize->selective_refresh->add_partial( 
		'footer_widgets', array(
		    'selector' => '.el-customize-footer-widgets',
		    'container_inclusive' => true,
		    'render_callback' => 'deux_footer_widgets'
        ) );

        $wp_customize->selective_refresh->add_partial( 
		'footer_widgets_layout', array(
		    'selector' => '.el-customize-footer-widgets',
		    'container_inclusive' => true,
		    'render_callback' => 'deux_footer_widgets'
        ) );      

        $wp_customize->selective_refresh->add_partial( 
		'footer_instagram', array(
		    'selector' => '.el-customize-footer-instagram',
		    'container_inclusive' => true,
		    'render_callback' => 'deux_footer_instagram'
        ) );     

	}
}
add_action( 'customize_register', 'deux_customize_setting_transactions' );

/**
 * Theme Customizer Active callback
 * @param  mixed $control
 * @return boolean
 */
function deux_customize_active_callback( $control ) {
	if ( ! class_exists('Kirki') ){
		return;
	}

    $logo_type = $control->manager->get_setting('logo_type')->value();
    $control_id = $control->id;

    if ( ( 'blogname' == $control_id || 'blogdescription' == $control_id ) && 'text' == $logo_type ) { return true; }
    
    return false;
}

/**
 * The custom control class
 */
function deux_kirki_enqueue_scripts() {
	wp_enqueue_style( 'deux-custom-kirki-style', get_parent_theme_file_uri( '/assets/css/admin/custom-kirki.css' ), array(), '20170106' );

	wp_enqueue_script( 'deux_customizer_script', get_parent_theme_file_uri( '/assets/js/admin/customize-section.js' ), array( 'jquery' ), NULL, true );
}

add_action( 'customize_controls_enqueue_scripts', 'deux_kirki_enqueue_scripts', 0 );

/**
 * Binds JS handlers to make Theme Customizer preview reload changes asynchronously.
 */
function deux_customize_preview_js() {
	wp_enqueue_script( 'deux_customizer_preview', get_parent_theme_file_uri( '/assets/js/admin/customize-preview.js' ), array( 'customize-preview' ), NULL, true );
}
add_action( 'customize_preview_init', 'deux_customize_preview_js' );

if( ! function_exists('deux_register_custom_font') ) :
	/**
	 * Add custom new font
	 */
	function deux_register_custom_font( $standard_fonts ) {

		$fonts = array();

		$fonts['arcamajora'] = array(
			'label' 	=> 'ArcaMajora',
			'variants'  => array('700'),
			'stack' 	=> 'ArcaMajora' 
		);

		return array_merge_recursive( $fonts, $standard_fonts );
	}

endif;
add_filter( 'kirki_fonts_standard_fonts', 'deux_register_custom_font', 20 );

/**
 * Disable unnecessary loader
 * @param  array $config 
 * @return bool
 */
function deux_disable_loader_kirki( $config ) {
	$config['disable_loader'] = true;

	return $config;
}
add_filter( 'kirki_config', 'deux_disable_loader_kirki' );

add_filter( 'kirki_load_fontawesome', '__return_false' );