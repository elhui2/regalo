<?php
/**
 * Display single product reviews (comments)
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product-reviews.php.
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
 * @version 	3.6.0
 */
if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}


global $product;

if ( ! comments_open() ) {
	return;
}

?>
<div id="reviews" class="woocommerce-Reviews">
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-8 col-lg-offset-2">

			<div id="comments">
				<h2 class="woocommerce-Reviews-title">
				
					<?php
					$count = $product->get_review_count();
					if ( $count && 'yes' === get_option( 'woocommerce_enable_review_rating' ) ) {
						/* translators: 1: reviews count 2: product name */
						$reviews_title = sprintf( esc_html( _n( '%1$s review for %2$s', '%1$s reviews for %2$s', $count, 'deux' ) ), esc_html( $count ), '<span>' . get_the_title() . '</span>' );
						echo apply_filters( 'woocommerce_reviews_title', $reviews_title, $count, $product ); // WPCS: XSS ok.
					} else {
						esc_html_e( 'Reviews', 'deux' );
					}
					?>
				
				</h2>

				<?php if ( have_comments() ) : ?>

					<ol class="commentlist">
						<?php wp_list_comments( apply_filters( 'woocommerce_product_review_list_args', array( 'callback' => 'woocommerce_comments' ) ) ); ?>
					</ol>

					<?php if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) :
						echo '<nav class="woocommerce-pagination">';
						paginate_comments_links( apply_filters( 'woocommerce_comment_pagination_args', array(
							'prev_text' => '&larr;',
							'next_text' => '&rarr;',
							'type'      => 'list',
						) ) );
						echo '</nav>';
					endif; ?>

				<?php else : ?>

					<p class="woocommerce-noreviews"><?php esc_html_e( 'There are no reviews yet.', 'deux' ); ?></p>

				<?php endif; ?>
			</div>

			<?php if ( get_option( 'woocommerce_review_rating_verification_required' ) === 'no' || wc_customer_bought_product( '', get_current_user_id(), $product->get_id() ) ) : ?>

				<div id="review_form_wrapper">
					<div id="review_form">
						<?php
						$commenter = wp_get_current_commenter();

						$comment_form = array(
							'title_reply'         => have_comments() ? esc_html__( 'Add a review', 'deux' ) : sprintf( esc_html__( 'Be the first to review &ldquo;%s&rdquo;', 'deux' ), get_the_title() ),
							'title_reply_to'      => esc_html__( 'Leave a Reply to %s', 'deux' ),
							'comment_notes_after' => '',
							'fields'              => array(
								'author' => '<p class="comment-form-author">' . '<label for="author">' . esc_html__( 'Name', 'deux' ) . ' <span class="required">*</span></label> ' .
									'<input id="author" name="author" type="text" value="' . esc_attr( $commenter['comment_author'] ) . '" size="30" aria-required="true" required /></p>',
								'email'  => '<p class="comment-form-email"><label for="email">' . esc_html__( 'Email', 'deux' ) . ' <span class="required">*</span></label> ' .
									'<input id="email" name="email" type="email" value="' . esc_attr( $commenter['comment_author_email'] ) . '" size="30" aria-required="true" required /></p>',
							),
							'label_submit'        => esc_html__( 'Submit', 'deux' ),
							'logged_in_as'        => '',
							'comment_field'       => ''
						);

						if ( $account_page_url = wc_get_page_permalink( 'myaccount' ) ) {
							$comment_form['must_log_in'] = '<p class="must-log-in">' . sprintf( esc_html__( 'You must be <a href="%s">logged in</a> to post a review.', 'deux' ), esc_url( $account_page_url ) ) . '</p>';
						}

						if ( 'yes' === get_option( 'woocommerce_enable_review_rating' ) ) {
							$comment_form['comment_field'] = '<p class="comment-form-rating"><label for="rating">' . esc_html__( 'Your Rating', 'deux' ) . '</label><select name="rating" id="rating" aria-required="true" required>
								<option value="">' . esc_html__( 'Rate&hellip;', 'deux' ) . '</option>
								<option value="5">' . esc_html__( 'Perfect', 'deux' ) . '</option>
								<option value="4">' . esc_html__( 'Good', 'deux' ) . '</option>
								<option value="3">' . esc_html__( 'Average', 'deux' ) . '</option>
								<option value="2">' . esc_html__( 'Not that bad', 'deux' ) . '</option>
								<option value="1">' . esc_html__( 'Very Poor', 'deux' ) . '</option>
							</select></p>';
						}

						$comment_form['comment_field'] .= '<p class="comment-form-comment"><label for="comment">' . esc_html__( 'Your Review', 'deux' ) . ' <span class="required">*</span></label><textarea id="comment" name="comment" cols="45" rows="8" aria-required="true" required></textarea></p>';

						comment_form( apply_filters( 'woocommerce_product_review_comment_form_args', $comment_form ) );
						?>
					</div>
				</div>

			<?php else : ?>

				<p class="woocommerce-verification-required"><?php esc_html_e( 'Only logged in customers who have purchased this product may leave a review.', 'deux' ); ?></p>

			<?php endif; ?>

		</div>
	</div>

	<div class="clear"></div>
</div>
