<?php
/**
 * Template part for displaying header with ... .
 *
 * @package Deux
 */
?>

<div class="row">
	<div class="mobile-nav-toggle col-xs-3 col-sm-3 col-md-3 hidden-lg">
		<span class="toggle-nav" data-target="mobile-menu"><span class="icon-burger"></span></span>
	</div>

	<div class="header-icon header-icon-left col-lg-3 hidden-xs hidden-sm hidden-md">
		<ul class="menu-icon">
			<?php deux_header_icons( 'v5', 'left' ) ?>
		</ul>
	</div><!-- .header-icon -->

	<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
		
		<div class="site-branding">
			<?php deux_branding_site_identity(); ?>
		</div><!-- .site-branding -->

		<nav id="site-navigation" class="main-navigation site-navigation hidden-xs hidden-sm hidden-md">
			<?php wp_nav_menu( array( 'theme_location' => 'primary', 'container' => false, 'menu_class' => 'nav-menu' ) ); ?>
		</nav><!-- #site-navigation -->
	</div>

	<div class="header-icon header-icon-right col-xs-3 col-sm-3 col-md-3 col-lg-3">
		<ul class="hidden-xs hidden-sm hidden-md">
			<?php deux_header_icons( 'v5', 'right' ) ?>
		</ul>

		<?php deux_mobile_header_icon(); ?>
	</div><!-- .header-icon -->


</div>