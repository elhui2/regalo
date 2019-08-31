<?php
/**
 * Template part for display single post content
 *
 * @package Deux
 */
?>
<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>
	<?php if ( 'no-sidebar' == deux_get_layout() ) : ?>
	<div class="row">
		<div class="col-md-10 col-md-offset-1 post-summary">
			<?php endif; ?>

			<div class="entry-content">
				<?php the_content(); ?>
				<?php
				wp_link_pages( array(
					'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'deux' ),
					'after'  => '</div>',
				) );
				?>
			</div>
			<!-- .entry-content -->

			<?php if ( has_tag() ) : ?>

			<footer class="entry-footer">
				<?php deux_entry_footer() ?>
			</footer>
			<!-- .entry-footer -->

			<?php endif; ?>

			<?php if ( 'no-sidebar' == deux_get_layout() ) : ?>
		</div>
	</div>
<?php endif; ?>

</article><!-- #post-## -->

