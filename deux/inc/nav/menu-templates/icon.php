<?php
$icons = deux_get_font_icons();
?>

<div id="smm-panel-icon" class="smm-panel-icon smm-panel">
	<div class="smm-icon-selector">
		<p>
			<span id="smm-selected-icon" title="<?php esc_attr_e( 'Click to remove', 'deux' ) ?>">
				<# if ( data.megaData.icon ) { #>
					<i class="{{ data.megaData.icon }}"></i>
				<# } #>
			</span>
			<span id="smm-remove-icon"></span>
			<input class="smm-icon-search" type="text" placeholder="<?php esc_attr_e( 'Search Icon', 'deux' ) ?>">
			<input id="smm-icon-input" type="hidden" name="{{ smm.getFieldName( 'icon', data.data['menu-item-db-id'] ) }}" value="{{ data.megaData.icon }}">
		</p>

		<hr>

		<div class="icons">
			<?php foreach( $icons as $icon ) : ?>
				<i class="<?php echo esc_attr( $icon ) ?>" data-icon="<?php echo esc_attr( $icon ) ?>"></i>
			<?php endforeach; ?>
		</div>
	</div>
</div>