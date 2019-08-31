<?php
/**
 * The sidebar containing the main widget area.
 *
 * @link    https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Deux
 */

if ( 'no-sidebar' == deux_get_layout() ) {
	return;
}

$view            = Deux_Frontend_View::Access();
$sidebar         = ( 'default' === $view ) ? 'blog-sidebar' : $view . '-sidebar';
$sidebar_classes = ( 'page' === $view ) ? array( 'col-md-3' ) : array( 'col-md-4' );
$sidebar_classes[] = $sidebar;

?>

<aside id="secondary" class="widget-area primary-sidebar <?php echo esc_attr( join( ' ', $sidebar_classes ) ) ?> " role="complementary">
	<?php dynamic_sidebar( $sidebar ); ?>
</aside><!-- #secondary -->
