<?php
if ( ! defined( 'ABSPATH' ) ) {
	die( '-1' );
}

/**
 * Shortcode attributes
 * @var $atts
 * @var $source
 * @var $text
 * @var $link
 * @var $google_fonts
 * @var $font_container
 * @var $el_class
 * @var $css
 * @var $font_container_data - returned from $this->getAttributes
 * @var $google_fonts_data   - returned from $this->getAttributes
 * Shortcode class
 * @var $this                WPBakeryShortCode_VC_Custom_heading
 */
$source = $text = $link = $google_fonts = $font_container = $el_class = $css = $font_container_data = $google_fonts_data = $separate_link = $link_arrow = '';
// This is needed to extract $font_container_data and $google_fonts_data
extract( $this->getAttributes( $atts ) );

$atts = vc_map_get_attributes( $this->getShortcode(), $atts );
extract( $atts );

extract( $this->getStyles( $el_class . $this->getCSSAnimation( $css_animation ), $css, $google_fonts_data, $font_container_data, $atts ) );


$settings = get_option( 'wpb_js_google_fonts_subsets' );
if ( is_array( $settings ) && ! empty( $settings ) ) {
	$subsets = '&subset=' . implode( ',', $settings );
} else {
	$subsets = '';
}

if ( isset( $google_fonts_data['values']['font_family'] ) ) {
	wp_enqueue_style( 'vc_google_fonts_' . vc_build_safe_css_class( $google_fonts_data['values']['font_family'] ), '//fonts.googleapis.com/css?family=' . $google_fonts_data['values']['font_family'] . $subsets );
}

if ( ! empty( $styles ) ) {
	$style = 'style="' . esc_attr( implode( ';', $styles ) ) . '"';
} else {
	$style = '';
}

if ( 'post_title' === $source ) {
	$text = get_the_title( get_the_ID() );
}

if ( ! empty( $link ) ) {
	$link = vc_build_link( $link );

	if ( $separate_link == 'yes' ) {
		$text .= sprintf(
			'<a href="%s" class="heading-link %s" %s>%s%s</a>',
			esc_attr( $link['url'] ),
			$link_arrow == 'yes' ? 'link-arrow' : '',
			$link['target'] ? ' target="' . esc_attr( $link['target'] ) . '"' : '',
			$link['title'] ? esc_html( $link['title'] ) : esc_html__( 'View more', 'deux' ),
			$link_arrow == 'yes' ? '<svg viewBox="0 0 20 20" width="20" height="20"><use xlink:href="#right-arrow"></use></svg>' : ''
		);
	} else {
		$text = '<a href="' . esc_attr( $link['url'] ) . '"'
		        . ( $link['target'] ? ' target="' . esc_attr( $link['target'] ) . '"' : '' )
		        . ( $link['title'] ? ' title="' . esc_attr( $link['title'] ) . '"' : '' )
		        . '>' . $text . '</a>';
	}
}

// Deux add more class for text align
if ( $font_container_data['values']['text_align'] ) {
	$css_class .= " text-{$font_container_data['values']['text_align']}";
}

$output = '';
if ( apply_filters( 'vc_custom_heading_template_use_wrapper', false ) ) {
	$output .= '<div class="' . esc_attr( $css_class ) . '" >';
	$output .= '<' . $font_container_data['values']['tag'] . ' ' . $style . ' >';
	$output .= $text;
	$output .= '</' . $font_container_data['values']['tag'] . '>';
	$output .= '</div>';
} else {
	$output .= '<' . $font_container_data['values']['tag'] . ' ' . $style . ' class="' . esc_attr( $css_class ) . '">';
	$output .= $text;
	$output .= '</' . $font_container_data['values']['tag'] . '>';
}

echo trim( $output );
