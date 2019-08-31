<?php

/**
* 
*/
class Deux_Dashboard_Template {

	public static function init() {
       $init = new self; 
       add_action( 'deux_welcome', array( $init, 'intro' ), 10 );
	   add_action( 'deux_welcome', array( $init, 'tabs' ), 20 );
	   add_action( 'deux_welcome', array( $init, 'getting_started' ), 30 );
	}
	
	public function __construct() {}

	public function intro() {
		get_template_part( 'lib/dashboard/sections/intro' );
	}

	public function tabs() {
		get_template_part( 'lib/dashboard/sections/tabs' );
	}
   
	public function getting_started() {
		get_template_part( 'lib/dashboard/sections/getting-started' );
	}
}

Deux_Dashboard_Template::init();