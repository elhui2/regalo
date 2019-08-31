<?php
/**
 * Registering meta boxes
 *
 * All the definitions of meta boxes are listed below with comments.
 *
 * For more information, please visit:
 * @link http://www.deluxeblogtips.com/meta-box/
 */


/**
 * Registering meta boxes
 *
 * Using Meta Box plugin: http://www.deluxeblogtips.com/meta-box/
 *
 * @see http://www.deluxeblogtips.com/meta-box/docs/define-meta-boxes
 *
 * @param array $meta_boxes Default meta boxes. By default, there are no meta boxes.
 *
 * @return array All registered meta boxes
 */
function deux_register_meta_boxes( $meta_boxes ) {
	// Post format's meta box
	$meta_boxes[] = array(
		'id'       => 'post-format-settings',
		'title'    => esc_html__( 'Format Details', 'deux' ),
		'pages'    => array( 'post' ),
		'context'  => 'normal',
		'priority' => 'high',
		'autosave' => true,
		'fields'   => array(
			array(
				'name'             => esc_html__( 'Image', 'deux' ),
				'id'               => 'image',
				'type'             => 'image_advanced',
				'class'            => 'image',
				'max_file_uploads' => 1,
			),
			array(
				'name'  => esc_html__( 'Gallery', 'deux' ),
				'id'    => 'images',
				'type'  => 'image_advanced',
				'class' => 'gallery',
			),
			array(
				'name'  => esc_html__( 'Audio', 'deux' ),
				'id'    => 'audio',
				'type'  => 'textarea',
				'cols'  => 20,
				'rows'  => 2,
				'class' => 'audio',
			),
			array(
				'name'  => esc_html__( 'Video', 'deux' ),
				'id'    => 'video',
				'type'  => 'textarea',
				'cols'  => 20,
				'rows'  => 2,
				'class' => 'video',
			),
		),
	);

	// Display Settings
	$meta_boxes[] = array(
		'id'       => 'display-settings',
		'title'    => esc_html__( 'Display Settings', 'deux' ),
		'pages'    => array( 'page' ),
		'context'  => 'normal',
		'priority' => 'high',
		'fields'   => array(
			array(
				'name' => esc_html__( 'Site Header', 'deux' ),
				'id'   => 'heading_site_header',
				'type' => 'heading',
			),
			array(
				'name'    => esc_html__( 'Header Background', 'deux' ),
				'id'      => 'site_header_bg',
				'type'    => 'select',
				'options' => array(
					''            => esc_html__( 'Default', 'deux' ),
					'white'       => esc_html__( 'White', 'deux' ),
					'transparent' => esc_html__( 'Transparent', 'deux' ),
				),
			),
			array(
				'name'    => esc_html__( 'Header Text Color', 'deux' ),
				'desc'    => esc_html__( 'This option only works if the header background is transparent', 'deux' ),
				'id'      => 'site_header_text_color',
				'class'   => 'site_header_text_color',
				'type'    => 'select',
				'options' => array(
					''      => esc_html__( 'Default', 'deux' ),
					'light' => esc_html__( 'Light', 'deux' ),
					'dark'  => esc_html__( 'Dark', 'deux' ),
				),
			),
			array(
				'name' => esc_html__( 'Page Header', 'deux' ),
				'id'   => 'heading_page_header',
				'type' => 'heading',
			),
			array(
				'name' => esc_html__( 'Hide Page Header', 'deux' ),
				'id'   => 'hide_page_header',
				'type' => 'checkbox',
				'std'  => false,
			),
			array(
				'name'             => esc_html__( 'Page Header Image', 'deux' ),
				'id'               => 'page_header_bg',
				'class'            => 'page-header-field',
				'type'             => 'image_advanced',
				'max_file_uploads' => 1,
			),
			array(
				'name'    => esc_html__( 'Page Header Text Color', 'deux' ),
				'id'      => 'page_header_text_color',
				'class'   => 'page-header-field',
				'type'    => 'select',
				'options' => array(
					''      => esc_html__( 'Default', 'deux' ),
					'light' => esc_html__( 'Light', 'deux' ),
					'dark'  => esc_html__( 'Dark', 'deux' ),
				),
			),
			array(
				'name'  => esc_html__( 'Hide Breadcrumb', 'deux' ),
				'id'    => 'hide_breadcrumb',
				'class' => 'page-header-field',
				'type'  => 'checkbox',
				'std'   => false,
			),
			array(
				'name'  => esc_html__( 'Hide Page Title', 'deux' ),
				'id'    => 'hide_page_title',
				'class' => 'hide-page-title',
				'type'  => 'checkbox',
				'std'   => false,
			),
			array(
				'name' => esc_html__( 'Layout', 'deux' ),
				'id'   => 'heading_layout',
				'type' => 'heading',
			),
			array(
				'name' => esc_html__( 'Custom Layout', 'deux' ),
				'id'   => 'custom_layout',
				'type' => 'checkbox',
				'std'  => false,
			),
			array(
				'name'    => esc_html__( 'Layout', 'deux' ),
				'id'      => 'layout',
				'type'    => 'image_select',
				'class'   => 'custom-layout',
				'options' => array(
					'no-sidebar'   => get_template_directory_uri() . '/assets/images/options/sidebars/empty-mb.png',
					'single-left'  => get_template_directory_uri() . '/assets/images/options/sidebars/single-left-mb.png',
					'single-right' => get_template_directory_uri() . '/assets/images/options/sidebars/single-right-mb.png',
				),
			),
		),
	);

	return $meta_boxes;
}

add_filter( 'rwmb_meta_boxes', 'deux_register_meta_boxes' );

/**
 * Enqueue scripts for admin
 *
 * @since  1.0
 */
function deux_meta_boxes_scripts( $hook ) {

	if ( in_array( $hook, array( 'post.php', 'post-new.php' ) ) ) {
		wp_enqueue_script( 'deux-meta-boxes', get_template_directory_uri() . '/assets/js/admin/meta-boxes.js', array( 'jquery' ), '20170730', true );
	}
}

add_action( 'admin_enqueue_scripts', 'deux_meta_boxes_scripts' );