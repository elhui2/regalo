<?php
/**
 * Template part for display single post content
 *
 * @package Deux
 */
?>

<div id="project-<?php the_ID() ?>" <?php post_class() ?>>
	<header class="port-header entry-header">

		<?php if ( has_post_thumbnail() ) : ?>
			<div class="port-image"><?php the_post_thumbnail( 'deux-portfolio-single' ) ?></div>
		<?php endif; ?>
	</header>

	<div class="port-content entry-content col-lg-10 col-md-12 col-lg-offset-1">
		<?php the_title( '<h1 class="port-title entry-title text-left ">', '</h1>' ) ;
			the_terms( get_the_ID(), 'portfolio_type', '<div class="port-meta entry-meta">', ', ', '</div>' ); 
		?>
		<?php the_content(); ?>
		<?php
		wp_link_pages( array(
			'before' => '<div class="page-links">' . esc_html__( 'Pages:', 'deux' ),
			'after'  => '</div>',
		) );
		?>
	</div>
</div>
