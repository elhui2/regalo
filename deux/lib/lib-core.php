<?php

if( ! class_exists( 'Deux_Library_Core' ) ) {

	/**
	* Single responsibility to load all files in library folder
	*/
	class Deux_Library_Core
	{
		
		/**
		 * load the files in the library folder
		 * @return void
		 */
		static public function init() {
			self::load_files();
		}

		/**
		 * Loads file in each folder
		 * @return void
		 */
		static public function load_files()	{
			require_once get_template_directory() . '/lib/kirki/installer-kirki.php';
			require_once get_template_directory() . '/lib/kirki/customizer-kirki.php';
			require_once get_template_directory() . '/lib/tgmpa/activation.php';
			require_once get_template_directory() . '/lib/tgmpa/register.php';
			require_once get_template_directory() . '/lib/helpers.php';
			require_once get_template_directory() . '/lib/ext/color.php';
			require_once get_template_directory() . '/lib/ext/breadcrumbs.php';
			if ( is_admin() ) {
				require get_template_directory() . '/lib/dashboard/api.php';
				require get_template_directory() . '/lib/dashboard/base.php';
				require get_template_directory() . '/lib/dashboard/template.php';
				require get_template_directory() . '/lib/dashboard/welcome.php';
				require get_template_directory() . '/lib/dashboard/ocdi.php';
			}
		}

	}

}

Deux_Library_Core::init();