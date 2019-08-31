<?php
/**
 * Simple product add to cart
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/add-to-cart/simple.php.
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
 * @version     3.4.0
 */

defined( 'ABSPATH' ) || exit;

global $product;

if ( ! $product->is_purchasable() ) {
	return;
}

if ( function_exists( 'wc_get_stock_html' ) ) {
	echo wc_get_stock_html( $product );
} else {
	// Availability
	$availability      = $product->get_availability();
	$availability_html = empty( $availability['availability'] ) ? '' : '<p class="stock ' . esc_attr( $availability['class'] ) . '">' . esc_html( $availability['availability'] ) . '</p>';

	echo apply_filters( 'woocommerce_stock_html', $availability_html, $availability['availability'], $product );
}


if ( $product->is_in_stock() ) : ?>

<div class="cart-container-functions">

	<?php do_action( 'woocommerce_before_add_to_cart_form' ); ?>

	<form class="cart" action="<?php echo esc_url( apply_filters( 'woocommerce_add_to_cart_form_action', $product->get_permalink() ) ); ?>" method="post" enctype='multipart/form-data'>
		<?php
		/**
		 * @since 2.1.0.
		 */
		do_action( 'woocommerce_before_add_to_cart_button' );

		/**
		 * @since 3.0.0.
		 */
		do_action( 'woocommerce_before_add_to_cart_quantity' );

		woocommerce_quantity_input( array(
			'min_value'   => apply_filters( 'woocommerce_quantity_input_min', method_exists( $product, 'get_min_purchase_quantity' ) ? $product->get_min_purchase_quantity() : 1, $product ),
			'max_value'   => apply_filters( 'woocommerce_quantity_input_max', method_exists( $product, 'get_max_purchase_quantity' ) ? $product->get_max_purchase_quantity() : ($product->backorders_allowed() ? '' : $product->get_stock_quantity()), $product ),
			'input_value' => isset( $_POST['quantity'] ) ? wc_stock_amount( wp_unslash( $_POST['quantity'] ) ) : ( method_exists( $product, 'get_min_purchase_quantity' ) ? $product->get_min_purchase_quantity() : 1 ),
		) );

		/**
		 * @since 3.0.0.
		 */
		do_action( 'woocommerce_after_add_to_cart_quantity' );
		?>

		<input type="hidden" name="add-to-cart" value="<?php echo esc_attr( $product->get_id() ); ?>" />
		<button type="submit" class="single_add_to_cart_button button alt">
			<?php echo esc_html( $product->single_add_to_cart_text() ); ?>
		</button>

		<?php
		/**
		 * @since 2.1.0.
		 */
		do_action( 'woocommerce_after_add_to_cart_button' );
		?>
	</form>

	<div id="cart-action-loader" class="cart-action-loader" style="display: none;">
		<span class="icon">
		<?php echo deux_get_svg_icon_html( deux_get_option( 'shop_cart_icon' ) ); ?>
		<span class="count counter-blink-me"></span>
		</span>
		<p class="adding"><?php esc_html_e( 'Adding to your cart...', 'deux' ); ?></p>
		<p class="added"><?php esc_html_e( 'Added to your cart', 'deux' ); ?></p>
	</div>

	<?php do_action( 'woocommerce_after_add_to_cart_form' ); ?>

</div>

<?php endif; ?>
