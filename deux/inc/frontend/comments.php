<?php
/**
 * Custom functions that act on comments.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package Deux
 */

/**
 * Remove Website field from comment form
 *
 * @param array $fields
 *
 * @return array
 */
function deux_disable_comment_url( $fields ) {
	unset( $fields['url'] );

	return $fields;
}

add_filter( 'comment_form_default_fields', 'deux_disable_comment_url' );


/**
 * Template Comment
 *
 * @since  1.0
 *
 * @param  array $comment
 * @param  array $args
 * @param  int   $depth
 *
 * @return mixed
 */
function deux_comment( $comment, $args, $depth ) {

	$add_below = 'div' == $args['style'] ? 'comment' : 'div-comment';
	?>

<li <?php comment_class( empty( $args['has_children'] ) ? '' : 'parent' ) ?> id="comment-<?php comment_ID() ?>">
	<article id="div-comment-<?php comment_ID() ?>" class="comment-body clearfix">

		<div class="comment-author vcard">
			<?php
			if ( $args['avatar_size'] != 0 ) {
				echo get_avatar( $comment, $args['avatar_size'] );
			}
			?>
		</div>
		<div class="comment-meta commentmetadata">
			<?php printf( '<cite class="author-name">%s</cite>', get_comment_author_link() ); ?>

			<a class="author-posted" href="<?php echo esc_url( get_comment_link( $comment->comment_ID ) ); ?>">
				<?php printf( '%1$s', get_comment_date( 'F d, Y' ) ); ?>
			</a>

			<?php if ( $comment->comment_approved == '0' ) : ?>
				<em class="comment-awaiting-moderation"><?php _e( 'Your comment is awaiting moderation.', 'deux' ); ?></em>
			<?php endif; ?>

			<div class="comment-content">
				<?php comment_text(); ?>
			</div>
			<div class="clearfix"></div>
			<?php
			comment_reply_link( array_merge(
				$args,
				array(
					'add_below'  => $add_below,
					'depth'      => $depth,
					'max_depth'  => $args['max_depth'],
					'reply_text' => sprintf( '<i class="fa fa-reply" aria-hidden="true"></i><span class="screen-reader-text">%s</span>', esc_html__( 'Reply', 'deux' ) ),
				)
			) );
			edit_comment_link( sprintf( '<span class="screen-reader-text">%s</span><i class="fa fa-pencil" aria-hidden="true"></i>', esc_html__( 'Edit', 'deux' ) ), '  ', '' );
			?>
		</div>
	</article>

	<?php
}