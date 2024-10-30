<?php
/**
 * Display items in admin.
 *
 * @author        Comdev
 * @category      Admin
 * @package       Comdev/Files
 * @version       1.0.0
 */

use Comdev\Files\Main;

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly.

if ( ! class_exists( 'Comdev_Files_Admin_Items' ) ) {
	/**
	 * Plugin_Name_Admin_List Class
	 */
	class Comdev_Files_Admin_Items {

		/**
		 * Comdev_Files_Admin_Items class construct.
		 */
		public function __construct() {

			$this->post_type = Main::CFP_POST_TYPE_NAME_ITEM;

			// Hook into WordPress initialization.
			add_action( 'init', [ $this, 'register_download_items' ] );
		}

		/**
		 * Register download item.
		 *
		 * @return void
		 */
		public function register_download_items(): void {
			$labels = [
				'name'               => _x( 'Downloads Items', 'Downloads Items', 'comdev-files' ),
				'menu_name'          => _x( 'Downloads Items', 'admin menu', 'comdev-files' ),
				'name_admin_bar'     => _x( 'Downloads Items', 'add new on admin bar', 'comdev-files' ),
				'add_new'            => _x( 'Add New', 'custom item', 'comdev-files' ),
				'add_new_item'       => __( 'Add New Download Item', 'comdev-files' ),
				'new_item'           => __( 'New Download Item', 'comdev-files' ),
				'edit_item'          => __( 'Edit Download Item', 'comdev-files' ),
				'view_item'          => __( 'View Download Item', 'comdev-files' ),
				'all_items'          => __( 'All Download Item', 'comdev-files' ),
				'search_items'       => __( 'Search Download Item', 'comdev-files' ),
				'parent_item_colon'  => __( 'Parent Download Item:', 'comdev-files' ),
				'not_found'          => __( 'No Download Item found.', 'comdev-files' ),
				'not_found_in_trash' => __( 'No Download Item found in Trash.', 'comdev-files' ),
			];

			$args = [
				'labels'          => $labels,
				'public'          => true,
				'show_ui'         => true,
				'show_in_menu'    => false,
				'query_var'       => true,
				'rewrite'         => [ 'slug' => 'download-items' ],
				'capability_type' => 'post',
				'has_archive'     => true,
				'hierarchical'    => false,
				'menu_position'   => null,
				'supports'        => [ 'title' ],
			];

			register_post_type( Main::CFP_POST_TYPE_NAME_ITEM, $args );
		}
	}

}

return new Comdev_Files_Admin_Items();
