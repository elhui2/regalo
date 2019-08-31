<h2 class="nav-tab-wrapper">
	<a href="#getting_started" class="nav-tab nav-tab-active"><?php _e( 'Getting Started', 'deux' ); ?></a>
	<?php if( class_exists( 'OCDI_Plugin' ) ) : ?>
	<a href="<?php echo esc_url( add_query_arg( 'page', 'deux-demo-installation', admin_url( 'themes.php' ) ) ); ?>" class="nav-tab"><span class="dashicons dashicons-upload"></span> <?php _e( 'Install Demos', 'deux' ); ?></a>
	<?php endif; ?>
</h2>