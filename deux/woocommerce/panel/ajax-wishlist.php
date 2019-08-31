<?php
/**
 * Deux Template for Ajax Wishlist
 * @version 1.0.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$products = YITH_WCWL()->get_products( array(
	'is_default' => true
) );

$limit = 3;

$products = array_reverse( $products );

$wl_count = YITH_WCWL()->count_products();
?>

<div class="deux-ajax-wishlist woocommerce">
<?php
if ( ! empty( $products ) ) : ?>
	<div class="woocommerce-mini-wishlist wishlist_list">
	<?php
	$i = 0;
	foreach( $products as $item ) {
		$i++;
		if( $i > $limit) break;
		if( function_exists( 'wc_get_product' ) ) {
			$_product = wc_get_product( $item['prod_id'] );
		}
		else{
			$_product = get_product( $item['prod_id'] );
		}

		if( ! $_product ) continue;

		$product_name  = $_product->get_title();
		$thumbnail     = $_product->get_image(); ?>

	<div class="wishlist_item">
		<?php if ( ! $_product->is_visible() ) : ?>
			<?php echo str_replace( array( 'http:', 'https:' ), '', $thumbnail ) . '&nbsp;'; ?>
		<?php else : ?>
			<a href="<?php echo esc_url( $_product->get_permalink() ); ?>" class="product-thumbnail">
				<?php echo str_replace( array( 'http:', 'https:' ), '', $thumbnail ); ?>
			</a>
		<?php endif; ?>
		
		<div class="product-wishlist-data">
		<span class="product-title">
			<a href="<?php echo esc_url( $_product->get_permalink() ); ?>"><?php echo esc_html( $product_name ); ?></a>
		</span>
		<?php echo WC()->cart->get_product_price( $_product ); ?>		
		</div>
    
	<div class="clear"></div>
	</div>

	<?php 
	} 
	?>
	
	</div>


	<p style="text-align:center;">
		<a href="<?php echo esc_url( YITH_WCWL()->get_wishlist_url() ); ?>" class="button btn-view-wishlist"><?php esc_html_e( 'View Wishlist', 'deux' ); ?></a>
	</p>

<?php else : ?>

	<p class="woocommerce-mini-wishlist__empty-message"><?php esc_html_e( 'No products were added to the wishlist.', 'deux' ); ?></p>

<?php endif; ?>
</div>