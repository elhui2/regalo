<?php
/**
 * Template Rating Ticker 
 * 
 * @version 1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

$args = array(
	'post_id' => $product_id,
	'number'  => $number_of_display,
	'status'  => 'approve'
);

$comments = get_comments( $args ); ?>

<div class="rating-ticker">
		<ul>
<?php
foreach ( $comments as $cmt ) : 
	$comment_user_rating = intval( get_comment_meta( $cmt->comment_ID, 'rating', true ) ); ?>
		<li>
			<?php echo wc_get_rating_html( $comment_user_rating, $rating_count ); ?>
			<a href="#reviews" class="woocommerce-review-link" rel="nofollow">
				<span><?php echo esc_html( $cmt->comment_author ); ?></span>
			</a>
			<span class="comment-content"><?php echo esc_html( strip_tags( $cmt->comment_content ) ); ?></span>
		</li>
<?php endforeach; ?>
	</ul>
</div>