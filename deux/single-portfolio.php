<?php
/**
 * The template for displaying all single portfolios.
 *
 * @link    https://developer.wordpress.org/themes/basics/template-hierarchy/
 *
 * @package Deux
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

			<?php

			while ( have_posts() ) : the_post();

				get_template_part( 'template-parts/content-single', 'portfolio' );

			endwhile; // End of the loop.

			if ( deux_get_option( 'project_share' ) ) { 
				echo '<div class="clearfix"></div>';
				echo '<div class="share-port">';
				deux_social_share(); 
				echo '</div>';

			}  

			if ( deux_get_option( 'project_navigation' ) ) {
				echo '<div class="col-lg-8 col-md-12 col-lg-offset-2">';
				the_post_navigation( array(
					'prev_text' => deux_get_font_icon_html( 'fa fa-long-arrow-left' ) . ' <span>' . deux_get_option( 'project_nav_text_prev' ) . '</span>',
					'next_text' => '<span>' . deux_get_option( 'project_nav_text_next' ) . '</span>' . deux_get_font_icon_html( 'fa fa-long-arrow-right' ),
					'screen_reader_text' => esc_html__( 'Project navigation', 'deux' ),
				) );
				echo '</div>';

			}

			?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_sidebar();
get_footer();
