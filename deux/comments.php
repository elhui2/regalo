<?php
/**
 * The template for displaying comments.
 *
 * This is the template that displays the area of the page that contains both the current comments
 * and the comment form.
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Deux
 */

/*
 * If the current post is protected by a password and
 * the visitor has not yet entered the password we will
 * return early without loading the comments.
 */
if ( post_password_required() ) {
	return;
}
?>

<div id="comments" class="comments-area">

	<?php if ( have_comments() ) : ?>
		<h2 class="comments-title">
			<span> <?php echo esc_html__( 'Comments', 'deux' ) . ' (' . get_comments_number() . ')' ?> </span>
		</h2>

		<?php
		the_comments_pagination( array(
			'prev_text' => deux_get_svg_icon_html( 'left-arrow' ),
			'next_text' => deux_get_svg_icon_html( 'right-arrow'),
		) );
		?>

		<ol class="comment-list">
			<?php
				wp_list_comments( array(
					'style'       => 'ol',
					'short_ping'  => true,
					'avatar_size' => 40,
					'callback'    => 'deux_comment',
				) );
			?>
		</ol><!-- .comment-list -->

		<?php
		the_comments_pagination( array(
			'prev_text' => deux_get_svg_icon_html( 'left-arrow' ),
			'next_text' => deux_get_svg_icon_html( 'right-arrow' ),
		) );
		?>

	<?php endif; // Check for have_comments().


	// If comments are closed and there are comments, let's leave a little note, shall we?
	if ( ! comments_open() && get_comments_number() && post_type_supports( get_post_type(), 'comments' ) ) : ?>
		<p class="no-comments"><?php esc_html_e( 'Comments are closed.', 'deux' ); ?></p>
	<?php
	endif;

	comment_form();
	?>

</div><!-- #comments -->
