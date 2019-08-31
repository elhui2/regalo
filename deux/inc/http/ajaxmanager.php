<?php
/**
 * @package Deux
 */

class Deux_Http_Ajaxmanager
{
	
	/**
	 * Helper Ajax Handler in class object
	 * @param  obj $object 
	 * @param  string $method
	 * @return void
	 */
	static public function register_obj( $object, $method, $prefix = 'deux' )
	{
		add_action( 
			"wp_ajax_{$prefix}_{$method}",
			array( $object, $method )
		);

		add_action( 
			"wp_ajax_nopriv_{$prefix}_{$method}",
			array( $object, $method )
		);
	}

	/**
	 * Helper Ajax Handler in function
	 * @param  string $method
	 * @return void
	 */
	static public function register_function( $method )
	{
		add_action( 
			"wp_ajax_$method",
		 	$method 
		);
		
		add_action( 
			"wp_ajax_nopriv_$method", 
			$method 
		);
	}
}