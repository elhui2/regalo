<?php
/**
 * Template part for displaying header with left menu ( default ).
 *
 * @package Deux
 */
?>

<div class="row">
	<nav id="site-navigation" class="main-navigation site-navigation col-xs-3 col-sm-3 col-md-3 col-lg-5">
		<span class="toggle-nav hidden-lg" data-target="mobile-menu"><span class="icon-burger"></span></span>
		<?php wp_nav_menu( array(
			'theme_location' => 'primary',
			'container'      => false,
			'menu_class'     => 'nav-menu',
		) ); ?>
	</nav><!-- #site-navigation -->

	<div class="site-branding col-xs-6 col-sm-6 col-md-6 col-lg-2">
		<?php deux_branding_site_identity(); ?>
	</div><!-- .site-branding -->

	<div class="header-icon col-xs-3 col-sm-3 col-md-3 col-lg-5">
		<ul class="hidden-xs hidden-sm hidden-md">
			<?php deux_header_icons( 'v1' ) ?>
		</ul>
		
		<?php deux_mobile_header_icon(); ?>
	</div><!-- .header-icon -->
</div>