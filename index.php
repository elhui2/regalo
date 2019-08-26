<?php

/**
 * index.php
 * @package WP Regalo
 * @version 0.1
 */
/*
  Plugin Name: WP Regalo
  Description: Personalizaciones del sitio El regalo de México
  Author: Daniel Huidobro
  Version: 0.1
  Author URI: https://rebootproject.mx
 */

add_filter('woocommerce_variable_sale_price_html', 'rm_remove_prices', 10, 2);
add_filter('woocommerce_variable_price_html', 'rm_remove_prices', 10, 2);
add_filter('woocommerce_get_price_html', 'rm_remove_prices', 10, 2);

function rm_remove_prices($price, $product)
{
  if (!is_admin()) $price = '';
  return $price;
}

/**
 * rm_custom_fields
 * @version 0.1
 * Personaliza el formulario de checkout
 */
add_filter('woocommerce_checkout_fields','rm_custom_fields');
function rm_custom_fields( $fields ) {
	unset($fields['billing']['billing_address_1']);
  unset($fields['billing']['billing_address_2']);
  unset($fields['billing']['billing_country']);
  unset($fields['billing']['billing_state']);
  unset($fields['billing']['billing_postcode']);
  
	return $fields;
}
