<?php
/**
 * Define the internationalization functionality
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @link       https://comdev.eu/wordpress-plugins/wordpress-download-plugin
 * @since      1.0.0
 *
 * @package    Comdev_Files
 * @subpackage Comdev_Files/includes
 */

/**
 * Define the internationalization functionality.
 *
 * Loads and defines the internationalization files for this plugin
 * so that it is ready for translation.
 *
 * @since      1.0.0
 * @package    Comdev_Files
 * @subpackage Comdev_Files/includes
 * @author     Comdev <comdev@aa.com>
 */
class Comdev_Files_I18n {

	/**
	 * Load the plugin text domain for translation.
	 *
	 * @return void
	 * @since    1.0.0
	 */
	public function load_plugin_textdomain(): void {

		load_plugin_textdomain(
			'comdev-files',
			false,
			dirname( dirname( plugin_basename( __FILE__ ) ) ) . '/languages/'
		);

	}
}
