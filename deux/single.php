<?php
/**
 * The template for displaying all single posts.
 *
 * @link https://developer.wordpress.org/themes/basics/template-hierarchy/#single-post
 *
 * @package Deux
 */

get_header(); ?>

	<div id="primary" class="content-area <?php deux_content_columns() ?>">
		<main id="main" class="site-main" role="main">
 	
			<?php  if (deux_get_option( 'single_post_layout' )):  ?>
				<div class="entry-header row">
					<div class="entry-header-inner col-md-10 col-md-offset-1">
						<div class="entry-meta">
							<?php deux_entry_meta(); ?>
						</div>
						<?php the_title( '<h1 class="entry-title">', '</h1>' );  ?>
					</div>
					<div class="clearfix"></div>
					<?php 
						echo '<div class="entry-thumbnail">';
						deux_entry_thumbnail( 'full' );
						echo '</div><!-- .entry-meta -->';

					 ?>
				</div>
			<?php endif ?>


			<?php

			while ( have_posts() ) : the_post();

				get_template_part( 'template-parts/content', 'single' );
 
				if( function_exists( 'deux_social_share' ) ) {
					echo '<div class="single-share">';
					deux_social_share();
					echo '</div>';
				}
	 
				if ( 'no-sidebar' == deux_get_layout() ) :
					echo '<div class="row"><div class="col-md-10 col-md-offset-1">';
				endif;

				if ( deux_get_option( 'post_author_box' ) ) {
					get_template_part( 'template-parts/biography' );
				}

				if ( deux_get_option( 'post_navigation' ) ) {
					deux_single_navigation_2();
				}

				if ( deux_get_option( 'post_related_posts' ) ) {
					get_template_part( 'template-parts/related-posts' );
				}

				// If comments are open or we have at least one comment, load up the comment template.
				if ( comments_open() || get_comments_number() ) :
					comments_template();
				endif;

				if ( 'no-sidebar' == deux_get_layout() ) :
					echo '</div></div>';
				endif;

			endwhile; // End of the loop.

			?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_sidebar();
get_footer();
