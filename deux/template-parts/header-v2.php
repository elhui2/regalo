<?php
/**
 * Template part for displaying header with center menu.
 *
 * @package Deux
 */
?>

<div class="row">
	<div class="mobile-nav-toggle col-xs-3 col-sm-3 col-md-3 hidden-lg">
		<span class="toggle-nav" data-target="mobile-menu"><span class="icon-burger"></span></span>
	</div>

	<div class="site-branding col-xs-6 col-sm-6 col-md-6 col-lg-3">
		<?php deux_branding_site_identity(); ?>
	</div><!-- .site-branding -->

	<nav id="site-navigation" class="main-navigation site-navigation hidden-xs hidden-sm hidden-md col-lg-6">
		<?php wp_nav_menu( array( 'theme_location' => 'primary', 'container' => false, 'menu_class' => 'nav-menu' ) ); ?>
	</nav><!-- #site-navigation -->

	<div class="header-icon col-xs-3 col-sm-3 col-md-3 col-lg-3">
		<ul class="hidden-xs hidden-sm hidden-md">
			<?php deux_header_icons( 'v2' ) ?>
		</ul>
		
		<?php deux_mobile_header_icon(); ?>
	</div><!-- .header-icon -->
</div>