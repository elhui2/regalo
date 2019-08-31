<div id="getting_started" class="col two-col panel" style="margin-bottom: 1.618em; padding-top: 1.618em; overflow: hidden;">
	

	<div class="col-1">		

		<div class="section theme-options">
			<h4><?php esc_html_e( 'Customizer settings' ,'deux' ); ?> <span class="dashicons dashicons-admin-generic"></span></h4>
			<p><?php esc_html_e( 'Take a look in the options of the Customizer and see yourself how easy and quick to customize your website as you wish.', 'deux' ); ?></p>
			<?php 
			$quick_settings = apply_filters( 'admin_customizer_quick_settings', array(
				    'title_tagline' 		=> 'Upload Logo',
					'general-section' 		=> 'General Settings',
					'scheme-section' 		=> 'Color Scheme',
					'typography-section' 	=> 'Customize Fonts',
					'header-section' 		=> 'Header Options',
					'mobile_menu-section' 	=> 'Header on mobile',
					'blog-section' 			=> 'Blog Settings',
					'shop-section' 			=> 'Shop Settings',
					'portfolio-section' 	=> 'Portfolio Settings',
					'footer-section' 		=> 'Footer Settings',
				) );
			?>
			
			<div class="postbox">
			<div class="quick-settings">
				<ul>
			<?php foreach ( $quick_settings as $section => $label ) : ?>
				<li>
					<?php 
					echo sprintf( '<a href="%1$s" target="_blank">%2$s</a>',
						 esc_url( admin_url( 'customize.php?autofocus[section]=' . esc_attr( $section ) ) ),
						 esc_html( $label )
					 );
					?>
				</li>
			<?php endforeach; ?>
				</ul>
			</div>
			</div>

		</div>

	</div>

	<div class="col-2 last-feature">
		<div class="section plugins">
			<h4><?php esc_html_e( 'Install recommended plugins' ,'deux' ); ?> <span class="dashicons dashicons-admin-plugins"></span></h4>
			<p><?php printf( esc_html__( '%sDeux%s harnesses the power and functionality of the popular and free ecommerce plugin %sWooCommerce%s.', 'deux' ), '<strong>', '</strong>', '<a target="blank" href="' . esc_url('https://wordpress.org/plugins/woocommerce/') . '"><strong>', '</strong></a>'); ?></p>

			<p><a href="<?php echo esc_url( self_admin_url( 'themes.php?page=tgmpa-install-plugins' ) ); ?>" class="button button-primary"><?php esc_html_e( 'Install &amp; Activate Recommended Plugins', 'deux' ); ?></a></p>
		</div>

		<h4><?php esc_html_e( 'Knowledge base', 'deux' ); ?> <span class="dashicons dashicons-welcome-learn-more"></span></h4>
		<p><?php esc_html_e( 'You can read detailed information on Deux\'s features and how to develop on top of it in the documentation.', 'deux' ); ?></p>
		<p><?php echo sprintf( esc_html('%sView documentation%s', 'deux'), '<a target="_blank" href="http://docs.qedqod.com/deux/" class="button button-primary">', '</a>'); ?></p>
	</div>

</div>