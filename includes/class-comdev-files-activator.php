<?php
/**
 * Fired during plugin activation
 *
 * @link       https://comdev.eu/wordpress-plugins/wordpress-download-plugin
 * @since      1.0.0
 *
 * @package    Comdev_Files
 * @subpackage Comdev_Files/includes
 */

use Comdev\Files\Main;

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    Comdev_Files
 * @subpackage Comdev_Files/includes
 * @author     Comdev <comdev@aa.com>
 */
class Comdev_Files_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @return void
	 * @since    1.0.0
	 */
	public static function activate(): void {

		global $wpdb;
		$table_name = $wpdb->prefix . Main::CFP_TEMPLATE_TABLE_NAME;

		$sql = "CREATE TABLE $table_name (
	    `id`      BIGINT NOT NULL auto_increment,
	    `template_id` varchar(255) NOT NULL,
	    `template_title` MEDIUMTEXT collate utf8mb4_unicode_ci NOT NULL,
	    `template_data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
	    `template_group` tinyint(1) NOT NULL DEFAULT '0',
	    `template_status` tinyint(1) NOT NULL DEFAULT '1',
	    `date_time` datetime NOT NULL DEFAULT CURRENT_TIMESTAMP,
	    UNIQUE KEY `id` ( `id` ));
		INSERT INTO $table_name  (`id`, `template_id`, `template_title`, `template_data`, `template_group`, `template_status`, `date_time`) VALUES
		(1, 'template-horizontal-1', 'Template Horizontal', '<div> <table class=\"cd-tbl-template-horizontal-1\"> <thead> <tr> <th scope=\"col\">Name</th> <th scope=\"col\">Version</th> <th scope=\"col\">Size</th> </tr> </thead> <tbody class=\"cd-files-table-body\"> {{listing}} </tbody> </table> </div>\r\n', 0, 1, '2024-03-24 11:38:05'),
		(2, 'template-horizontal-2', 'Template Horizontal 2', '<div> <table class=\"cd-tbl-template-horizontal-2\"> <thead> <tr> <th scope=\"col\">Name</th> <th scope=\"col\">Version</th> <th scope=\"col\">Size</th> </tr> </thead> <tbody class=\"cd-files-table-body\"> {{listing}} </tbody> </table> </div>', 0, 1, '2024-03-24 11:38:05');";

		require_once ABSPATH . 'wp-admin/includes/upgrade.php';
		dbDelta( $sql );

		update_option( 'comdev_files_setting_user_access', 'false' );
		update_option( 'comdev_files_setting_show_ver', '1' );
		update_option( 'comdev_files_setting_show_size', '1' );
		update_option( 'comdev_files_setting_file_ext', 'jpg,gif,png,zip' );
	}
}
