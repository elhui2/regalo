<?php
/**
 * Loop Add to Cart
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/add-to-cart.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

global $product;

echo apply_filters( 'woocommerce_loop_add_to_cart_link',
	sprintf( 
		'<a rel="nofollow" href="%s" data-quantity="%s" data-product_id="%s" data-product_sku="%s" data-url="%s" class="%s">%s<span class="screen-reader-text">%s</span></a>',
		esc_url( $product->add_to_cart_url() ),
		esc_attr( isset( $args['quantity'] ) ? $args['quantity'] : 1 ),
		esc_attr( $product->get_id() ),
		esc_attr( $product->get_sku() ),
		esc_url( get_permalink() ),
		esc_attr( isset( $args['class'] ) ? $args['class'] : 'button' ),
		'<svg viewBox="0 0 20 20"><use xlink:href="#' . (deux_get_option( 'product_quickview' ) && deux_get_option( 'product_quickview_behavior' ) == 'buy_button' ? 'quickview-eye' : deux_get_option( 'shop_cart_icon' ) ) . '"></use></svg>',
		esc_html( $product->add_to_cart_text() )
	),
$product );
