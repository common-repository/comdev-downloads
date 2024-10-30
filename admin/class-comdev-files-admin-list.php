<?php
/**
 * Display notices in admin.
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

if ( ! class_exists( 'Comdev_Files_Admin_List' ) ) {
	/**
	 * Comdev_Files_Admin_List class.
	 */
	class Comdev_Files_Admin_List {

		/**
		 * Comdev_Files_Admin_List construct
		 */
		public function __construct() {

			$this->post_type = Main::CFP_POST_TYPE_NAME_ITEM_LIST;

			add_action( 'init', [ $this, 'register_downloads' ] );
		}

		/**
		 * Register download list.
		 *
		 * @return void
		 */
		public function register_downloads(): void {
			$labels = [
				'name'               => _x( 'Downloads', 'Downloads', 'comdev-files' ),
				'menu_name'          => _x( 'Downloads List', 'admin menu', 'comdev-files' ),
				'name_admin_bar'     => _x( 'Downloads List', 'add new on admin bar', 'comdev-files' ),
				'add_new'            => _x( 'Add New', 'custom item', 'comdev-files' ),
				'add_new_item'       => __( 'Add Download List', 'comdev-files' ),
				'new_item'           => __( 'New Download List', 'comdev-files' ),
				'edit_item'          => __( 'Edit Download List', 'comdev-files' ),
				'view_item'          => __( 'View Download List', 'comdev-files' ),
				'all_items'          => __( 'All Download List', 'comdev-files' ),
				'search_items'       => __( 'Search Download List', 'comdev-files' ),
				'parent_item_colon'  => __( 'Parent Download List:', 'comdev-files' ),
				'not_found'          => __( 'No Download List.', 'comdev-files' ),
				'not_found_in_trash' => __( 'No Download List found in Trash.', 'comdev-files' ),
			];

			$args = [
				'labels'          => $labels,
				'public'          => true,
				'show_ui'         => true,
				'show_in_menu'    => false,
				'query_var'       => true,
				'rewrite'         => [ 'slug' => 'download-list' ],
				'capability_type' => 'post',
				'has_archive'     => true,
				'hierarchical'    => false,
				'menu_position'   => null,
				'supports'        => [ 'title', 'editor' ],
				'taxonomies'      => [ 'category', 'post_tag' ],
			];

			register_post_type( Main::CFP_POST_TYPE_NAME_ITEM_LIST, $args );

		}
	}

}

return new Comdev_Files_Admin_List();
