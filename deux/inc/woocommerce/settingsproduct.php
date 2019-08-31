<?php
/**
 * Class Deux_WooCommerce_SettingsProduct
 *
 * Add for fields into a product data meta box
 */
class Deux_WooCommerce_SettingsProduct {
	/**
	 * Initialize
	 */
	public static function init() {
		add_action( 'woocommerce_product_options_advanced', array( __CLASS__, 'add_advanced_options' ) );

		add_action( 'save_post', array( __CLASS__, 'save_product_data' ) );
	}

	/**
	 * Add more fields to "Advanced" product data tab
	 */
	public static function add_advanced_options() { ?>

		<div class="options_group">
	    <?php
		woocommerce_wp_checkbox( array(
			'id'            => '_is_new',
			'label'         => esc_html__( 'New product?', 'deux' ),
			'description'   => esc_html__( 'Enable to set this product as a new product. A "New" badge will be added to this product.', 'deux' ),
		) ); ?>
		</div>

		<div class="options_group">
		<?php
			woocommerce_wp_text_input( array(
				'id'                => '_custom_tab_heading_one',
				'label'             => __( 'Custom Tab Heading 1', 'deux' ),
				'desc_tip'          => true,
				'description'       => __( 'Enter Custom Tab heading.', 'deux' ),
				'type'              => 'text',
			) );

			woocommerce_wp_textarea_input( array(
				'id'          => '_custom_tab_content_one',
				'label'       => __( 'Custom Tab Content 1', 'deux' ),
				'class'		  => '' 
			) );

			woocommerce_wp_text_input( array(
				'id'                => '_custom_tab_heading_two',
				'label'             => __( 'Custom Tab Heading 2', 'deux' ),
				'desc_tip'          => true,
				'description'       => __( 'Enter Custom Tab heading.', 'deux' ),
				'type'              => 'text',
			) );

			woocommerce_wp_textarea_input( array(
				'id'          => '_custom_tab_content_two',
				'label'       => __( 'Custom Tab Content 2', 'deux' ),
				'class'		  => '' 
			) );
		?>
		</div>

	<?php
	}

	/**
	 * Save product data
	 *
	 * @param int $post_id
	 */
	public static function save_product_data( $post_id ) {
		if ( 'product' !== get_post_type( $post_id ) ) {
			return;
		}

		if ( ! isset( $_POST['_is_new'] ) ) {
			delete_post_meta( $post_id, '_is_new' );
		} else {
			update_post_meta( $post_id, '_is_new', 'yes' );
		}

		// Tab One
		if ( ! isset( $_POST['_custom_tab_heading_one'] ) ) {
			delete_post_meta( $post_id, '_custom_tab_heading_one' );
		} else {
			update_post_meta( $post_id, '_custom_tab_heading_one', wp_unslash( $_POST['_custom_tab_heading_one'] ) );
		}

		if ( ! isset( $_POST['_custom_tab_content_one'] ) ) {
			delete_post_meta( $post_id, '_custom_tab_content_one' );
		} else {
			update_post_meta( $post_id, '_custom_tab_content_one', wp_kses_post( wp_unslash( $_POST['_custom_tab_content_one'] ) ) );
		}

		// Tab Two
		if ( ! isset( $_POST['_custom_tab_heading_two'] ) ) {
			delete_post_meta( $post_id, '_custom_tab_heading_two' );
		} else {
			update_post_meta( $post_id, '_custom_tab_heading_two', wp_unslash( $_POST['_custom_tab_heading_two'] ) );
		}

		if ( ! isset( $_POST['_custom_tab_content_two'] ) ) {
			delete_post_meta( $post_id, '_custom_tab_content_two' );
		} else {
			update_post_meta( $post_id, '_custom_tab_content_two', wp_kses_post( wp_unslash( $_POST['_custom_tab_content_two'] ) ) );
		}
	}
}