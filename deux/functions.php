<?php
/**
 * Deux functions and definitions.
 *
 * Set up the theme and provides some helper functions, which are used in the
 * theme as custom template tags. Others are attached to action and filter
 * hooks in WordPress to change core functionality.
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * When using a child theme you can override certain functions (those wrapped
 * in a function_exists() call) by defining them first in your child theme's
 * functions.php file. The child theme's functions.php file is included before
 * the parent theme's file, so the child theme functions would be used.
 *
 * @link https://codex.wordpress.org/Theme_Development
 * @link https://codex.wordpress.org/Child_Themes
 *
 * Functions that are not pluggable (not wrapped in function_exists()) are
 * instead attached to a filter or action hook.
 *
 * For more information on hooks, actions, and filters,
 * {@link https://codex.wordpress.org/Plugin_API}
 *
 * @package Deux
 */

/**
 * Load the library folder
 */
require_once get_template_directory() . '/lib/lib-core.php';

/**
 * Load all clasess
 */
require get_parent_theme_file_path( '/inc/autoloader.php' );

/**
 * Check custom condition
 */
require get_parent_theme_file_path( '/inc/conditionals.php' );

/**
 * Theme setup
 */
require get_parent_theme_file_path( '/inc/theme-setup.php' );

/**
 * Custom template tags for this theme.
 */
require get_parent_theme_file_path( '/inc/functions-icons.php' );
require get_parent_theme_file_path( '/inc/template-tags.php' );


/**
 * Customizer additions
 */
require get_parent_theme_file_path( '/inc/customizer/services.php' );
require get_parent_theme_file_path( '/inc/customizer/register.php' );

/**
 * Metabox
 */
require get_parent_theme_file_path( '/inc/metabox/register.php' );

/**
 * Custom functions that act in the frontend.
 */
require get_parent_theme_file_path( '/inc/frontend/dynamic-css.php' );
require get_parent_theme_file_path( '/inc/frontend/frontend.php' );
require get_parent_theme_file_path( '/inc/frontend/header.php' );
require get_parent_theme_file_path( '/inc/frontend/footer.php' );
require get_parent_theme_file_path( '/inc/frontend/entry.php' );
require get_parent_theme_file_path( '/inc/frontend/comments.php' );
