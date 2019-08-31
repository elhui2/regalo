<?php

class Deux_Dashboard_Welcome extends Deux_Dashboard_Base {
	
	public function __construct() {
		parent::__construct();
	}

	public static function init() {
		static $instance = null;

		if ( is_null( $instance ) ) {
			$instance = new self;
		}
		
		add_action( 'admin_menu', array( $instance, 'register_menu' ) );		
	}

	/**
	 * Creates the dashboard page
	 * @see  add_theme_page()
	 * @since 1.0.0
	 */
	public function register_menu() {
		$menu_title = sprintf( 'About %s', $this->theme_obj->get( 'Name' ) );
		$welcome = add_theme_page( $menu_title, $menu_title, 'read', $this->theme_obj->get_template().'-welcome', array( $this, 'screen' ) );
		add_action( 'admin_print_styles-'. $welcome, array( $this, 'admin_css' ) );
	}
    
    public function admin_css(){
		wp_enqueue_style( 'deux-welcome-screen', get_template_directory_uri() . '/lib/dashboard/welcome.css', '1.0.0' );    	
    }

	public function screen() { 
		?>
		<div class="wrap about-wrap">

			<?php
			/**
			 * @hooked intro - 10
			 * @hooked getting_started - 20
			 * @hooked who - 60
			 */
			do_action( 'deux_welcome' ); ?>

		</div>
		<?php	
	}
}

Deux_Dashboard_Welcome::init();