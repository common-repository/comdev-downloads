<?php
/**
 * Admin Settings Class.
 *
 * @package    Comdev_Files
 * @subpackage Comdev_Files/admin
 * @author     Comdev <comdev@aa.com>
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly.

if ( ! class_exists( 'Comdev_Files_Admin_Templates' ) ) {

	/**
	 * Comdev_Files_Admin_Templates
	 */
	class Comdev_Files_Admin_Templates extends Comdev_Files_Admin {
		/**
		 * Option name.
		 *
		 * @var string
		 */
		private $option_name = 'comdev_files_templates';

		/**
		 * Comdev_Files_Admin_Templates construct.
		 */
		public function __construct() {
			$plugin_name       = 'comdev-files';
			$this->plugin_name = $plugin_name;
		}

		/**
		 * Get templates form database.
		 *
		 * @return array|object|stdClass[]|null
		 */
		public function get_templates_from_database() {
			global $wpdb;

			//phpcs:disable
			$results = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}cdf_downloads WHERE template_group = '0'" );

			//phpcs:enable
			return $results;
		}

		/**
		 * Get templates packages form database.
		 *
		 * @return array|object|stdClass[]|null
		 */
		public function get_templates_packages_from_database() {
			global $wpdb;

			//phpcs:disable
			$results = $wpdb->get_results( "SELECT * FROM {$wpdb->prefix}cdf_downloads WHERE template_group = '1'" );

			//phpcs:enable

			return $results;
		}


	}

}

return new Comdev_Files_Admin_Templates();
