<?php
/**
 * Result Count
 *
 * Shows text: Showing x - x of x results.
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/loop/result-count.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see 	    https://docs.woocommerce.com/document/template-structure/
 * @author 		WooThemes
 * @package 	WooCommerce/Templates
 * @version     3.3.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

global $wp_query;

if ( ! woocommerce_products_will_display() )
	return;
?>
<p class="woocommerce-result-count">
	<?php
	$total    = $wp_query->found_posts; ?>

    <span class="result-count__intro"><?php esc_html_e( 'Displaying', 'deux' ); ?></span>
    <?php
	printf( _n( '%2$s%1$d%3$s Product', '%2$s%1$d%3$s Products', $total, 'deux' ), $total, '<span class="result-count__number">', '</span>' );
	?>
</p>
