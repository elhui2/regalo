<?php
/**
 * The template part for displaying related posts
 *
 * @package Deux
 */

// Only support posts
if ( 'post' != get_post_type() ) {
	return;
}

$related_posts = new WP_Query(
	array(
		'post_type'              => 'post',
        'post_status'            => 'publish',
		'posts_per_page'         => 9,
		'ignore_sticky_posts'    => 1,
		'category__in'           => wp_get_post_categories( get_the_ID() ),
		'post__not_in'           => array( get_the_ID() ),
	)
);

if ( $related_posts->have_posts() ) : ?>

	<div class="clearfix"></div>
	<div class="related-posts">
		<h2 class="related-title"><?php esc_html_e( 'Related Posts', 'deux' ) ?></h2>
		<div class="deux-carousel" data-columns="3">
			<div class="related-content products">
				<?php while ( $related_posts->have_posts() ) : $related_posts->the_post(); ?>
						<div>
					<?php if (has_post_thumbnail()): ?>
							<a href="<?php the_permalink() ?>" class="post-thumbnail" rel="bookmark">
								<?php the_post_thumbnail( 'deux-blog-grid' ) ?>
							</a>
					<?php endif; ?>
							<h3 class="post-title">
								<a href="<?php the_permalink() ?>" rel="bookmark">
									<?php the_title() ?>
								</a>
							</h3>
						</div>

				<?php endwhile; ?>
			</div>
		</div>
	</div>

<?php endif;

wp_reset_postdata();