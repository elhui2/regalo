<?php
/**
 * Class Deux_Nav_MegaMenuEdit
 *
 * Main class for adding mega setting modal
 */
class Deux_Nav_MegaMenuEdit {
	/**
	 * Modal screen of mega menu settings
	 *
	 * @var array
	 */
	public $modals = array();

	public static function init() {
		static $instance = null;

		if ( is_null( $instance ) ) {
			$instance = new self;
			$instance->setup_actions();
		}

		return $instance;
	}

	/**
	 * Class constructor.
	 */
	public function __construct() {
		$this->modals = apply_filters( 'deux_mega_menu_modals', array(
			'menus',
			'title',
			'mega',
			'background',
			'icon',
			'content',
			'design',
			'settings',
		) );
	}

	public function setup_actions() {
		add_filter( 'wp_edit_nav_menu_walker', array( $this, 'edit_walker' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'scripts' ) );
		add_action( 'admin_footer-nav-menus.php', array( $this, 'modal' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'templates' ) );
		add_action( 'wp_ajax_deux_save_menu_item_data', array( $this, 'save_menu_item_data' ) );
	}

	/**
	 * Change walker class for editing nav menu
	 *
	 * @return string
	 */
	public function edit_walker() {
		return 'Deux_Nav_MegaMenuWalkerEdit';
	}

	/**
	 * Load scripts on Menus page only
	 *
	 * @param string $hook
	 */
	public function scripts( $hook ) {
		if ( 'nav-menus.php' !== $hook ) {
			return;
		}

		wp_register_style( 'font-awesome', get_template_directory_uri() . '/assets/css/font-awesome.min.css', array(), '4.6.3' );
		wp_register_style( 'deux-mega-menu-admin', get_template_directory_uri() . '/assets/css/admin/mega-menu.css', array(
			'media-views',
			'wp-color-picker',
			'font-awesome',
		) );
		wp_enqueue_style( 'deux-mega-menu-admin' );

		wp_register_script( 'deux-mega-menu-admin', get_template_directory_uri() . '/assets/js/admin/mega-menu.js', array(
			'jquery',
			'jquery-ui-resizable',
			'wp-util',
			'wp-color-picker',
		), null, true );
		wp_enqueue_media();
		wp_enqueue_script( 'deux-mega-menu-admin' );

		wp_localize_script( 'deux-mega-menu-admin', 'smmModals', $this->modals );
	}

	/**
	 * Prints HTML of modal on footer
	 */
	public function modal() {
		?>
		<div id="smm-settings" tabindex="0" class="smm-settings">
			<div class="smm-modal media-modal wp-core-ui">
				<button type="button" class="button-link media-modal-close smm-modal-close">
					<span class="media-modal-icon"><span class="screen-reader-text"><?php esc_html_e( 'Close', 'deux' ) ?></span></span>
				</button>
				<div class="media-modal-content">
					<div class="smm-frame-menu media-frame-menu">
						<div class="smm-menu media-menu"></div>
					</div>
					<div class="smm-frame-title media-frame-title"></div>
					<div class="smm-frame-content media-frame-content">
						<div class="smm-content"></div>
					</div>
					<div class="smm-frame-toolbar media-frame-toolbar">
						<div class="smm-toolbar media-toolbar">
							<div class="smm-toolbar-primary media-toolbar-primary search-form">
								<button type="button" class="button smm-button smm-button-save media-button button-primary button-large"><?php esc_html_e( 'Save Changes', 'deux' ) ?></button>
								<button type="button" class="button smm-button smm-button-cancel media-button button-secondary button-large"><?php esc_html_e( 'Cancel', 'deux' ) ?></button>
								<span class="spinner"></span>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="media-modal-backdrop smm-modal-backdrop"></div>
		</div>
		<?php
	}

	/**
	 * Prints underscore template on footer
	 */
	public function templates( $hook ) {

		if( 'nav-menus.php' != $hook) {
			return;
		}

		foreach ( $this->modals as $template ) {
			$file = apply_filters( 'deux_mega_menu_js_template_path', 
					get_theme_file_path( 'inc/nav/menu-templates/' . $template . '.php' ), $template );
			?>
			<script type="text/html" id="tmpl-deux-<?php echo esc_attr( $template ) ?>">
				<?php 
				if ( file_exists( $file ) ) {
					include $file;
				} 
				?>
			</script>
			<?php
		}

	}

	/**
	 * Ajax function to save menu item data
	 */
	public function save_menu_item_data() {
		if( isset( $_POST['data'] ) ){
			$_POST['data'] = wp_unslash( $_POST['data'] );
			parse_str( wp_unslash( $_POST['data'] ), $data );
		}
		$updated = $data;

		// Save menu item data
		foreach ( $data['menu-item-mega'] as $id => $meta ) {
			$old_meta = get_post_meta( $id, '_menu_item_mega', true );
			$old_meta = deux_parse_args( $old_meta, deux_get_mega_menu_setting_default() );
			$meta     = deux_parse_args( $meta, $old_meta );

			$updated['menu-item-mega'][ $id ] = $meta;

			update_post_meta( $id, '_menu_item_mega', $meta );
		}

		wp_send_json_success( $updated );
	}

}