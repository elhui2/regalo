<?php
/**
 * @package Deux
 */

/**
 * Autoloader for deux classes.
 *
 * Based on an example implementation of PSR-4, but compatible with PHP 5.2.
 *
 * @link http://www.php-fig.org/psr/psr-4/examples/
 *
 * @param string $class
 */

function deux_autoload_classes( $class ) {
	// Prefix for all classes
	$prefix = 'Deux_';

	// Prefix character length
	$length = strlen( $prefix );

	// Does the current class have the required prefix?
	if ( 0 !== strncmp( $prefix, $class, $length ) ) {
		// No, move to the next registered autoloader.
		return;
	}

	// Base directory for all classes
	$base_dir = get_template_directory() . '/inc/';

	// Class without the top-level prefix
	$relative_class = strtolower( substr( $class, $length ) );

	// Full path of the class file
	$file = $base_dir . str_replace( '_', '/', $relative_class ) . '.php';

	// Load the file if it exists and is readable
	if ( is_readable( $file ) ) {
		require_once $file;
	}
}

spl_autoload_register( 'deux_autoload_classes' );