<?php
/**
 * Fired during plugin deactivation
 *
 * @link       https://comdev.eu/wordpress-plugins/wordpress-download-plugin
 * @since      1.0.0
 *
 * @package    Comdev_Files
 * @subpackage Comdev_Files/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    Comdev_Files
 * @subpackage Comdev_Files/includes
 * @author     Comdev <comdev@aa.com>
 */
class Comdev_Files_Deactivator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @return void
	 * @since    1.0.0
	 */
	public static function deactivate(): void {
		delete_option( 'comdev_files_notifications_activate' );
		delete_option( 'comdev_files_setting_file_ext' );
		delete_option( 'comdev_files_setting_file_template' );
		delete_option( 'comdev_files_setting_show_ver' );
		delete_option( 'comdev_files_setting_show_size' );
		delete_option( 'comdev_files_setting_file_info' );
		delete_option( 'comdev_files_setting_user_access' );
	}
}
