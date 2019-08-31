<?php
/**
 * The header for our theme.
 *
 * This is the template that displays all of the <head> section and everything up until <div id="content">
 *
 * @link https://developer.wordpress.org/themes/basics/template-files/#template-partials
 *
 * @package Deux
 */
?><!DOCTYPE html>
<html itemscope itemtype=<?php echo esc_url( deux_schema_attribute() ); ?> <?php language_attributes(); ?>>
<head>
<meta charset="<?php bloginfo( 'charset' ); ?>">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="profile" href="http://gmpg.org/xfn/11">
<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>">

<?php wp_head(); ?>
</head>

<body <?php body_class(); ?> <?php deux_attr_body(); ?>>

<?php do_action( 'deux_site_before' ) ?>

<div id="page" class="site">
	<?php do_action( 'deux_header_before' ); ?>

	<header id="masthead" class="site-header" role="banner">
		<div class="<?php echo 'full-width' == deux_get_option( 'header_wrapper' ) ? 'deux-container clearfix' : 'container' ?>">

			<?php do_action( 'deux_header' ); ?>

		</div>
	</header><!-- #masthead -->

	<?php do_action( 'deux_header_after' ); ?>

	<div id="content" class="site-content">

		<?php do_action( 'deux_content_before' ); ?>