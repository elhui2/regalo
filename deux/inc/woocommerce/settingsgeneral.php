<?php
/**
 * Class Deux_WooCommerce_SettingsGeneral
 * Adds more settings into WooCommerce's settings
 */
class Deux_WooCommerce_SettingsGeneral {
	/**
	 * Initialize
	 */
	public static function init() {
		add_filter( 'woocommerce_get_settings_checkout', array( __CLASS__, 'add_order_tracking_setting' ) );
		add_filter( 'woocommerce_get_settings_products', array( __CLASS__, 'product_settings' ), 10, 2 );
	}

	/**
	 * Adds deux_order_tracking_page_id setting field to checkout tab
	 *
	 * @param array $settings
	 *
	 * @return array
	 */
	public static function add_order_tracking_setting( $settings ) {
		$new_settings = array();

		foreach ( $settings as $index => $setting ) {
			$new_settings[ $index ] = $setting;

			if ( isset( $setting['id'] ) && 'woocommerce_terms_page_id' == $setting['id'] ) {
				$new_settings['order_tracking_page_id'] = array(
					'title'    => esc_html__( 'Order Tracking Page', 'deux' ),
					'desc'     => esc_html__( 'Page content: [woocommerce_order_tracking]', 'deux' ),
					'id'       => 'deux_order_tracking_page_id',
					'type'     => 'single_select_page',
					'class'    => 'wc-enhanced-select-nostd',
					'css'      => 'min-width:300px;',
					'desc_tip' => true,
				);
			}
		}

		return $new_settings;
	}

	public static function product_settings( $settings, $section ) {
		$new_settings = array();

		foreach ( $settings as $index => $setting ) {
			$new_settings[ $index ] = $setting;

			if ( isset( $setting['id'] ) && 'woocommerce_cart_redirect_after_add' == $setting['id'] ) {
				$new_settings['deux_enable_single_ajax_add_to_cart'] = array(
					'desc'          => esc_html__( 'Enable AJAX add to cart button on single', 'deux' ),
					'id'            => 'deux_enable_single_ajax_add_to_cart',
					'default'       => 'no',
					'type'          => 'checkbox',
					'checkboxgroup' => '',
				);
			}
		}

		$settings = $new_settings;

		return $settings;
	}
}