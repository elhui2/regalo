<?php
/**
 * The template for displaying 404 pages (not found).
 *
 * @link https://codex.wordpress.org/Creating_an_Error_404_Page
 *
 * @package Deux
 */

get_header(); ?>

	<div id="primary" class="content-area">
		<main id="main" class="site-main" role="main">            
            <?php if ( deux_get_option( '404_custom_content' ) !== '' ) : ?>

				<?php echo do_shortcode( wp_kses_post( deux_get_option( '404_custom_content' ) ) ); ?>
				
            <?php else : ?>
			<section class="error-404 not-found">
				<header class="page-header">
					<h1 class="page-title"><?php esc_html_e( 'Not Found', 'deux' ); ?></h1>
				</header>

				<div class="page-content">
					<?php esc_html_e( 'Sometimes getting lost isn\'t that bad.', 'deux' ); ?>
				</div>

				<div class="page-search">
					<form role="search" method="get" class="search-form" action="<?php echo esc_url( home_url( '/' ) ); ?>">
							<input type="search" class="search-field" placeholder="<?php esc_attr_e( 'Enter keywords', 'deux' ) ?>" value="" name="s">
						<input type="submit" class="search-submit" value="<?php esc_attr_e( 'Search', 'deux' ) ?>">				
						<?php echo deux_get_svg_icon_html( 'search' ); ?>
					</form>
				</div>
			</section><!-- .error-404 -->
			<?php endif; ?>

		</main><!-- #main -->
	</div><!-- #primary -->

<?php
get_footer();
