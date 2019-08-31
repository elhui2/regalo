<?php
/**
 * Template part for displaying topbar
 */
if ( ! deux_get_option( 'topbar_enable' ) ) {
	return;
}
?>
<div id="topbar" class="topbar">
	<div class="deux-container">

		<?php if ( '2-columns' == deux_get_option( 'topbar_layout' ) ) : ?>

			<div class="row">
				<div class="topbar-left topbar-content text-left col-md-6">
					<?php
					switch ( deux_get_option( 'topbar_left' ) ) {
						case 'switchers':
							deux_currency_switcher();
							deux_language_switcher();
							break;

						default:
							echo do_shortcode( deux_get_option( 'topbar_content' ) );
							break;
					}
					?>
				</div>

				<div class="topbar-menu text-right col-md-6">
					<?php
					if ( has_nav_menu( 'topbar' ) ) {
						wp_nav_menu( array( 'theme_location' => 'topbar', 'menu_id' => 'topbar-menu', 'menu_class' => 'topbar-menu nav-menu' ) );
					}
					?>
				</div>
			</div>

		<?php else : ?>

			<div class="topbar-content text-center">
				<?php echo do_shortcode( deux_get_option( 'topbar_content' ) ); ?>
			</div>

		<?php endif; ?>

	</div>
</div>
