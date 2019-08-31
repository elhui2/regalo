<?php
/**
 * Template part for displaying projects
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Deux
 */
?>
<div id="project-<?php the_ID() ?>" <?php post_class( 'col-xs-6 col-sm-4 col-md-4' ) ?>>
	<?php if ( has_post_thumbnail() ) : ?>
		<a href="<?php the_permalink() ?>" class="port-thumbnail">
			<?php the_post_thumbnail( 'deux-portfolio' ) ?>
			<span class="view-more">
				<?php echo deux_get_font_icon_html( 'fa fa-link' ); ?>
			</span>
		</a>
	<?php endif; ?>
	<h3 class="port-title"><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h3>
</div>