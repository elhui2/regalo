<?php
/**
 * Template part for displaying header with ... .
 *
 * @package Deux
 */
?>

<div id="site-navigation" class="site-nav">
	<span class="toggle-nav hidden-md hidden-lg" data-target="mobile-menu"><span class="icon-burger"></span></span>
	<span class="toggle-nav hidden-xs hidden-sm" data-target="primary-menu"><span class="icon-burger"></span></span>
	<span class="toggle-nav hidden-xs hidden-sm menu-text" data-target="primary-menu">
		<?php esc_html_e( 'Menu', 'deux' ); ?>
	</span>
	<div class="header-icon">
		<ul class="hidden-xs hidden-sm hidden-md">
			<?php deux_header_icons( 'v6', 'left' ) ?>
		</ul>
	</div><!-- .header-icon -->
</div><!-- #site-navigation -->

<div class="site-branding">
	<?php deux_branding_site_identity(); ?>
</div><!-- .site-branding -->

<div class="header-icon header-icon-left">
	<div class="lang-cur-switcher hidden-xs hidden-sm hidden-md">
		<?php 
			deux_language_switcher(); 
			deux_currency_switcher();
		?>
	</div>
	<ul class="hidden-xs hidden-sm">
		<ul class="hidden-xs hidden-sm hidden-md">
			<?php deux_header_icons( 'v6', 'right' ) ?>
		</ul>
	</ul>

	<?php deux_mobile_header_icon(); ?>
</div><!-- .header-icon -->
