<?php 
/**
 * @package Deux
 */

class Deux_Http_Assets
{

	/**
	 * Reduce rendering unminify css
	 * @param  string $css 
	 * @return string      
	 */
	static public function minify_css( $css ) 
	{
	    $output = preg_replace( '#/\*.*?\*/#s', '', $css );     // 1
		$output = preg_replace( '/\s*([{}|:;,])\s+/', '$1', $output ); // 2
		$output = preg_replace( '/\s\s+(.*)/', '$1', $output );        // 3
		$output = preg_replace( '/;}/','}', $output ); // 4

		return $output;
	}
    
}