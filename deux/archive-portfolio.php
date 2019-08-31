<?php
/**
 * The template for displaying portfolio archive pages
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Deux
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">

			<?php
			if ( have_posts() ) :

				if ( deux_get_option( 'portfolio_filter' ) ) {
					deux_portfolio_filter();
				}

				echo '<div class="portfolio-items row">';

				/* Start the Loop */
				while ( have_posts() ) : the_post();

					get_template_part( 'template-parts/content-portfolio', deux_get_option( 'portfolio_style' ) );

				endwhile;

				echo '</div><!-- .portfolio-items -->';

				printf(
					'<nav class="navigation portfolio-navigation ajax-navigation" role="navigation">%s</nav>',
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

			else :

				get_template_part( 'template-parts/content', 'none' );

			endif; ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_sidebar();
get_footer();
