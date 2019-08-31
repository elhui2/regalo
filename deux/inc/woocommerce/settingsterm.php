<?php
/**
 * Class Deux_WooCommerce_TermSettings
 * Adds more fields into term edit form
 */
class Deux_WooCommerce_SettingsTerm {
	/**
	 * Initialize
	 */
	public static function init() {
		if ( ! deux_is_woocommerce_activated() ) {
			return;
		}

		// Add fields
		add_action( 'product_cat_edit_form_fields', array( __CLASS__, 'edit_category_fields' ), 20 );
		add_action( 'edit_term', array( __CLASS__, 'save_category_fields' ), 20, 3 );

		add_action( 'admin_enqueue_scripts', array( __CLASS__, 'enqueue_scripts' ) );
	}

	/**
	 * Enqueue scripts
	 *
	 * @param string $hook
	 */
	public static function enqueue_scripts( $hook ) {
		if ( ! in_array( $hook, array( 'term.php', 'edit-tags.php' ) ) ) {
			return;
		}

		wp_enqueue_script( 'deux-term-page-header-image', get_template_directory_uri() . '/assets/js/admin/terms.js', array( 'jquery' ), wp_get_theme()->get( 'Version' ), true );
		wp_localize_script( 'deux-term-page-header-image', 'deuxTermData', array(
			'placeholder' => wc_placeholder_img_src(),
			'l10n'        => array(
				'title'  => esc_html__( 'Choose an image', 'deux' ),
				'button' => esc_html__( 'Use image', 'deux' ),
			),
		) );
	}

	/**
	 * Edit category page header fields.
	 *
	 * @param mixed $term Term (category) being edited
	 */
	public static function edit_category_fields( $term ) {
		$text_color   = get_term_meta( $term->term_id, 'page_header_text_color', true );
		$thumbnail_id = absint( get_term_meta( $term->term_id, 'page_header_image_id', true ) );
		$image        = $thumbnail_id ? wp_get_attachment_thumb_url( $thumbnail_id ) : wc_placeholder_img_src();
		?>

		<tr class="form-field">
			<th scope="row" valign="top"><label><?php esc_html_e( 'Page Header Image', 'deux' ); ?></label>
			</th>
			<td>
				<div id="product_cat_page_header" style="float: left; margin-right: 10px;">
					<img src="<?php echo esc_url( $image ); ?>" width="60px" height="60px" /></div>
				<div style="line-height: 60px;">
					<input type="hidden" id="product_cat_image_id" name="page_header_image_id" value="<?php echo esc_attr( $thumbnail_id ); ?>" />
					<button type="button" class="upload_header_image_button button"><?php esc_html_e( 'Upload/Add image', 'deux' ); ?></button>
					<button type="button" class="remove_header_image_button button"><?php esc_html_e( 'Remove image', 'deux' ); ?></button>
				</div>
				<div class="clear"></div>
			</td>
		</tr>

		<tr class="form-field">
			<th scope="row" valign="top">
				<label for="page_header_text_color"><?php esc_html_e( 'Page Header Text Color', 'deux' ); ?></label>
			<td>
				<select name="page_header_text_color" id="page_header_text_color" class="postform">
					<option><?php esc_html_e( 'Default', 'deux' ) ?></option>
					<option value="dark" <?php selected( 'dark', $text_color ) ?>><?php esc_html_e( 'Dark', 'deux' ) ?></option>
					<option value="light" <?php selected( 'light', $text_color ) ?>><?php esc_html_e( 'Light', 'deux' ) ?></option>
				</select>
			</td>
		</tr>
		<?php
	}

	/**
	 * save_category_fields function.
	 *
	 * @param mixed  $term_id Term ID being saved
	 * @param mixed  $tt_id
	 * @param string $taxonomy
	 */
	public static function save_category_fields( $term_id, $tt_id = '', $taxonomy = '' ) {
		if ( isset( $_POST['page_header_image_id'] ) && 'product_cat' === $taxonomy ) {
			update_term_meta( $term_id, 'page_header_image_id', absint( $_POST['page_header_image_id'] ) );
		}

		if ( isset( $_POST['page_header_text_color'] ) && 'product_cat' === $taxonomy ) {
			update_term_meta( $term_id, 'page_header_text_color', esc_attr( wp_unslash( $_POST['page_header_text_color'] ) ) );
		}
	}
}