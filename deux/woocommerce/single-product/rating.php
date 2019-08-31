<?php
/**
 * Single Product Rating
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/rating.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see     https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 3.6.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

global $product;

if ( ! wc_review_ratings_enabled() ) {
	return;
}

$rating_count = $product->get_rating_count();
$review_count = $product->get_review_count();
$average      = $product->get_average_rating();

if ( $rating_count > 0 ) : ?>

	<div class="woocommerce-product-rating">
		<?php 
		if( deux_get_option( 'enable_product_star_rating_ticker' ) ) : 

			wc_get_template( 'single-product/rating-ticker.php', array(
				'product_id'		=> $product->get_id(),
				'rating_count'      => $rating_count,
				'number_of_display' => deux_get_option( 'product_star_rating_ticker_number' )
			) );

		else:
		?>

		<?php echo wc_get_rating_html( $average, $rating_count ); ?>
		<?php if ( comments_open() ) : ?><a href="#reviews" class="woocommerce-review-link" rel="nofollow"><?php printf( _n( '%s customer review', '%s customer reviews', $review_count, 'deux' ), '<span class="count">' . esc_html( $review_count ) . '</span>' ); ?></a><?php endif; ?>

	<?php endif; ?>
	</div>

<?php else: ?>

	<div class="woocommerce-product-rating">
		<div class="star-rating"></div>
		<a href="#reviews" class="woocommerce-review-link" rel="nofollow"><?php esc_html_e( 'Be the first to review this item!', 'deux' ) ?></a>
	</div>

<?php endif; ?>
