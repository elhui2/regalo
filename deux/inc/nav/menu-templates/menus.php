<# if ( data.depth == 0 ) { #>
	<a href="#" class="media-menu-item active" data-title="<?php esc_attr_e( 'Mega Menu Content', 'deux' ) ?>" data-panel="mega"><?php esc_html_e( 'Mega Menu', 'deux' ) ?></a>
	<a href="#" class="media-menu-item" data-title="<?php esc_attr_e( 'Mega Menu Background', 'deux' ) ?>" data-panel="background"><?php esc_html_e( 'Background', 'deux' ) ?></a>
	<div class="separator"></div>
	<a href="#" class="media-menu-item" data-title="<?php esc_attr_e( 'Menu Icon', 'deux' ) ?>" data-panel="icon"><?php esc_html_e( 'Icon', 'deux' ) ?></a>
<# } else if ( data.depth == 1 ) { #>
	<a href="#" class="media-menu-item active" data-title="<?php esc_attr_e( 'Menu Setting', 'deux' ) ?>" data-panel="settings"><?php esc_html_e( 'Settings', 'deux' ) ?></a>
	<a href="#" class="media-menu-item" data-title="<?php esc_attr_e( 'Menu Design', 'deux' ) ?>" data-panel="design"><?php esc_html_e( 'Design', 'deux' ) ?></a>
	<a href="#" class="media-menu-item" data-title="<?php esc_attr_e( 'Menu Content', 'deux' ) ?>" data-panel="content"><?php esc_html_e( 'Content', 'deux' ) ?></a>
	<a href="#" class="media-menu-item" data-title="<?php esc_attr_e( 'Menu Icon', 'deux' ) ?>" data-panel="icon"><?php esc_html_e( 'Icon', 'deux' ) ?></a>
<# } else { #>
	<a href="#" class="media-menu-item active" data-title="<?php esc_attr_e( 'Menu Content', 'deux' ) ?>" data-panel="content"><?php esc_html_e( 'Content', 'deux' ) ?></a>
	<a href="#" class="media-menu-item" data-title="<?php esc_attr_e( 'Menu Icon', 'deux' ) ?>" data-panel="icon"><?php esc_html_e( 'Icon', 'deux' ) ?></a>
<# } #>
