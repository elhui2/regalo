<?php
/**
 * Customize and add more fields for mega menu
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Class Deux_Nav_MegaMenuWalkerEdit
 *
 * Class for adding more controllers into a menu item
 */
class Deux_Nav_MegaMenuWalkerEdit extends Walker_Nav_Menu_Edit {
	/**
	 * Start the element output.
	 *
	 * @see   Walker_Nav_Menu::start_el()
	 * @since 3.0.0
	 *
	 * @global int   $_wp_nav_menu_max_depth
	 *
	 * @param string $output Passed by reference. Used to append additional content.
	 * @param object $item   Menu item data object.
	 * @param int    $depth  Depth of menu item. Used for padding.
	 * @param array  $args   Not used.
	 * @param int    $id     Not used.
	 */
	public function start_el( &$output, $item, $depth = 0, $args = array(), $id = 0 ) {
		$mega = get_post_meta( $item->ID, '_menu_item_mega', true );
		$mega = deux_parse_args( $mega, deux_get_mega_menu_setting_default() );

		$item_output = '';
		parent::start_el( $item_output, $item, $depth, $args );

		// Allows plugins to add more fields
		$item_output = preg_replace(
			'/(?=<(p|fieldset)[^>]+class="[^"]*field-move)/',
			$this->custom_fields( $item, $depth, $args ),
			$item_output
		);

		$dom = new DOMDocument();

		$dom->validateOnParse = true;
		$dom->loadHTML( mb_convert_encoding( $item_output, 'HTML-ENTITIES', 'UTF-8' ) );
		$xpath = new DOMXPath( $dom );

		// Remove spaces in href attribute
		$anchors = $xpath->query( "//a" );

		foreach ( array_reverse( iterator_to_array( $anchors ) ) as $anchor ) {
			$anchor->setAttribute( 'href', trim( $anchor->getAttribute( 'href' ) ) );
		}

		// Adds mega menu data holder
		$settings = $xpath->query( "//*[@id='menu-item-settings-" . $item->ID . "']" )->item( 0 );

		if ( $settings ) {
			$node            = $dom->createElement( 'span' );
			$node->nodeValue = $mega['content'];
			unset( $mega['content'] );
			$node->setAttribute( 'data-mega', json_encode( $mega ) );
			$node->setAttribute( 'class', 'hidden mega-data' );
			$settings->appendChild( $node );
		}

		// Add settings link
		$cancel = $xpath->query( "//*[@id='cancel-" . $item->ID . "']" )->item( 0 );

		if ( $cancel ) {
			$link            = $dom->createElement( 'a' );
			$link->nodeValue = esc_html__( 'Settings', 'deux' );
			$link->setAttribute( 'class', 'item-config-mega opensettings submitcancel hide-if-no-js' );
			$link->setAttribute( 'href', '#' );
			$sep            = $dom->createElement( 'span' );
			$sep->nodeValue = ' | ';
			$sep->setAttribute( 'class', 'meta-sep hide-if-no-js' );
			$cancel->parentNode->insertBefore( $link, $cancel );
			$cancel->parentNode->insertBefore( $sep, $cancel );
		}

		$output .= $dom->saveHTML();
	}

	/**
	 * Get custom fields from plugins
	 *
	 * @param object $item
	 * @param int    $depth
	 * @param array  $args
	 *
	 * @return string
	 */
	protected function custom_fields( $item, $depth, $args = array() ) {
		ob_start();

		/**
		 * Get menu item custom fields from plugins/themes
		 *
		 * @param object $item  Menu item data object.
		 * @param int    $depth Depth of menu item. Used for padding.
		 * @param array  $args  Menu item args.
		 *
		 * @return string
		 */
		do_action( 'wp_nav_menu_item_custom_fields', $item->ID, $item, $depth, $args );

		return ob_get_clean();
	}
}