<?php
/**
 * Template part for displaying posts.
 *
 * @link    https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Deux
 */

global $wp_query;

if ( 'grid' == deux_get_option( 'blog_layout' ) ) {
	$blog_image_size = 'deux-blog-grid';

	if ( 'no-sidebar' == deux_get_layout() ) {
		$blog_post_class = 'grid-post col-md-4 aos-item';
		if ( ( $wp_query->current_post + 1 ) == 1 || ( $wp_query->current_post + 1 ) == 2 ) {
			$blog_image_size = 'deux-blog-thumbnail';
		}
	} else {
		$blog_post_class = 'grid-post col-md-6 aos-item';
		if ( ( $wp_query->current_post + 1 ) == 1 ) {
			$blog_image_size = 'deux-blog-thumbnail';
		}
	}
	
} else {
	if ( ( $wp_query->current_post + 1 ) == 1 ) {
		$blog_image_size = 'deux-blog-thumbnail';
		$blog_post_class = 'big-post';
	} else {
		$blog_image_size = 'deux-blog-grid';
		$blog_post_class = 'clearfix small-post';
	}
}

?>
<article id="post-<?php the_ID(); ?>" <?php post_class( $blog_post_class ); ?> data-aos="<?php echo esc_attr( deux_get_option( 'products_item_animate' ) );?>" data-aos-duration="800">
	
	<div class="entry-container">
		<?php if ( has_post_thumbnail() ) : ?>
			<a href="<?php the_permalink() ?>" class="post-thumbnail">
				<?php
				the_post_thumbnail( $blog_image_size );

				if ( 'gallery' == get_post_format() ) {
					?>
					<span class="format-icon">
						<?php echo deux_get_font_icon_html( 'fa fa-clone' ); ?>
					</span>
					<?php
				} elseif ( 'video' == get_post_format() ) {
					?>
					<span class="format-icon">
						<?php echo deux_get_font_icon_html( 'fa fa-play' ); ?>
					</span>
					<?php
				} elseif ( 'audio' == get_post_format() ) {
					?>
					<span class="format-icon">
						<?php echo deux_get_font_icon_html( 'fa fa-music' ); ?>						
					</span>
					<?php
				}
				?>
			</a>
		<?php endif; ?>

		<div class="post-summary">
			<?php the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' ); ?>

			<div class="entry-meta"><?php deux_entry_meta(); ?></div>
			<div class="clearfix"></div>
			<div class="entry-summary">
				<?php the_excerpt(); ?>
			</div><!-- .entry-content -->

			<a class="read-more" href="<?php the_permalink() ?>"><?php esc_html_e( 'Read more', 'deux' ) ?></a>
		</div>
	</div>
</article><!-- #post-## -->
