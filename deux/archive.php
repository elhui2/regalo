<?php
/**
 * The template for displaying archive pages
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Deux
 */

get_header(); ?>

	<div id="primary" class="content-area <?php deux_content_columns() ?>">
		<main id="main" class="site-main" role="main">

		<?php
		if ( have_posts() ) :

			/* Start the Loop */
			while ( have_posts() ) : the_post();

				/*
				 * Include the Post-Format-specific template for the content.
				 * If you want to override this in a child theme, then include a file
				 * called content-___.php (where ___ is the Post Format name) and that will be used instead.
				 */
				get_template_part( 'template-parts/content', get_post_format() );

			endwhile;

			if ( 'classic' == deux_get_option( 'blog_layout' ) ) {
				the_posts_pagination( array(
					'prev_text' => deux_get_svg_icon_html( 'left-arrow' ),
					'next_text' => deux_get_svg_icon_html( 'right-arrow' ),
				) );
			} else {
				printf(
					'<nav class="navigation posts-navigation ajax-navigation" role="navigation">%s</nav>',
					get_next_posts_link( '
							<span class="button-text"> 
								<span class="bubble">
									<span class="dot"></span> 
								</span>
								<span class="bubble">
									<span class="dot"></span> 
								</span>
								<span class="bubble">
									<span class="dot"></span> 
								</span>
							</span>

							<span class="loading-icon">
								<span class="bubble">
									<span class="dot"><span class="dot__color dot__color--1"></span></span>
								</span>
								<span class="bubble">
									<span class="dot"><span class="dot__color dot__color--2"></span></span>
								</span>
								<span class="bubble">
									<span class="dot"><span class="dot__color dot__color--3"></span></span>
								</span>
							</span>' 
						)
				);
			}

		else :

			get_template_part( 'template-parts/content', 'none' );

		endif; ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_sidebar();
get_footer();
