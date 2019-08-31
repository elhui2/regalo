<?php
/**
 * Template part for displaying projects in masonry portfolio page
 *
 * @link https://codex.wordpress.org/Template_Hierarchy
 *
 * @package Deux
 */

global $wp_query;
$current_project = $wp_query->current_post + 1;
$current_project_mod = $current_project % 5;
$project_thumbnail_size = 'deux-portfolio';
$project_class = 'col-sm-3 col-md-3';

if ( in_array( $current_project_mod, array( 1, 2 ) ) ) {
	$project_thumbnail_size = 'deux-portfolio-large';
	$project_class = 'col-sm-6 col-md-6';
}
if ( in_array( $current_project_mod, array( 4 ) ) ) {
	$project_thumbnail_size = 'deux-portfolio-wide';
	$project_class = 'col-sm-6 col-md-6';
}
?>
<?php if ( has_post_thumbnail() ) : ?>
<div id="project-<?php the_ID() ?>" <?php post_class( $project_class ) ?>>
		<a href="<?php the_permalink() ?>" class="port-thumbnail">
			<?php the_post_thumbnail( $project_thumbnail_size ) ?>
		</a>
	<div class="port-summary">
		<h3 class="port-title"><a href="<?php the_permalink() ?>"><?php the_title(); ?></a></h3>
		<?php
		if ( has_term( null, 'portfolio_type' ) ) {
			the_terms( get_the_ID(), 'portfolio_type', '<div class="port-type">', ', ', '</div>' );
		}
		?>
	</div>
</div>
<?php endif; ?>