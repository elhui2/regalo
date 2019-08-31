<?php

class Deux_Dashboard_Base {
	
	protected $theme_obj = null;

	protected $notification;

	public function __construct(){

		$this->themeData();
		$this->notification  = '<p>' . sprintf( 'Welcome! Thank you for choosing %1$s! To fully take advantage of the best our theme can offer please make sure you visit our %2$swelcome page%3$s.', $this->theme_obj->get( 'Name' ), '<a href="' . esc_url( admin_url( 'themes.php?page=' . $this->theme_obj->get_template() . '-welcome' ) ) . '">', '</a>' ) . '</p><p><a href="' . esc_url( admin_url( 'themes.php?page=' . $this->theme_obj->get_template() . '-welcome' ) ) . '" class="button" style="text-decoration: none;">' . sprintf( 'Get started with %s', $this->theme_obj->get( 'Name' ) ) . '</a></p>';
		
		/* activation notice */
		add_action( 'load-themes.php', array( $this, 'activation_admin_notice' ) );
	}

	protected function themeData() {
		$this->theme_obj = wp_get_theme();
	}

	public function activation_admin_notice() {
		global $pagenow;
		if ( is_admin() && ( 'themes.php' == $pagenow ) && isset( $_GET['activated'] ) ) {
			add_action( 'admin_notices', array( $this, 'about_page_welcome_admin_notice' ), 99 );
		}
	}

	public function about_page_welcome_admin_notice() {
		if ( ! empty( $this->notification ) ) {
			echo '<div class="updated notice is-dismissible">';
			echo wp_kses_post( $this->notification );
			echo '</div>';
		}
	}

}