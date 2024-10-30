<?php
/**
 * The admin-specific functionality of the plugin.
 *
 * @link       https://comdev.eu/wordpress-plugins/wordpress-download-plugin
 * @since      1.0.0
 *
 * @package    Comdev_Files
 * @subpackage Comdev_Files/admin
 */

use Comdev\Files\Main;

/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Comdev_Files
 * @subpackage Comdev_Files/admin
 * @author     Comdev <comdev@aa.com>
 */
class Comdev_Files_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string $plugin_name The ID of this plugin.
	 */
	private $plugin_name;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string $version The current version of this plugin.
	 */
	private $version;

	/**
	 * Option name.
	 *
	 * @var string
	 */
	private $option_name = 'comdev_files_setting';

	/**
	 * Initialize the class and set its properties.
	 *
	 * @param string $plugin_name The name of this plugin.
	 * @param string $version     The version of this plugin.
	 *
	 * @since    1.0.0
	 */
	public function __construct( $plugin_name, $version ) {

		$this->plugin_name = $plugin_name;
		$this->version     = $version;
		$this->includes();
		add_action( 'admin_menu', [ $this, 'add_menu' ] );
	}

	/**
	 * Include any classes we need within admin.
	 */
	public function includes(): void {
		// Functions.
		include_once 'class-' . $this->plugin_name . '-admin-settings.php';
		include_once 'class-' . $this->plugin_name . '-admin-list.php';
		include_once 'class-' . $this->plugin_name . '-admin-items.php';
		include_once 'class-' . $this->plugin_name . '-admin-templates.php';
		include_once $this->plugin_name . '-admin-functions.php';
	}


	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @param string $hook Page slug.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles( string $hook ): void {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Comdev_Files_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Comdev_Files_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */
		global $post_type;

		if (
			preg_match( '/comdev-downloads_page/', $hook ) ||
			preg_match( '/comdev-files/', $hook ) ||
			Main::CFP_POST_TYPE_NAME_ITEM_LIST === $post_type ||
			Main::CFP_POST_TYPE_NAME_ITEM === $post_type ||
			is_post_type_archive(
				[
					Main::CFP_POST_TYPE_NAME_ITEM_LIST,
					Main::CFP_POST_TYPE_NAME_ITEM,
				]
			)
		) {

			/** Load UIKIT */
			wp_enqueue_style( 'uikit', plugin_dir_url( __FILE__ ) . 'css/uikit.min.css', '', '3.19.2', 'all' );
			wp_enqueue_style( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'css/comdev-files-admin.css', [], $this->version, 'all' );
		}
	}


	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @param string $hook Page slug.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts( string $hook ): void {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Comdev_Files_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Comdev_Files_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		global $post_type;

		if (
			preg_match( '/comdev-downloads_page/', $hook ) ||
			preg_match( '/comdev-files/', $hook ) ||
			Main::CFP_POST_TYPE_NAME_ITEM_LIST === $post_type ||
			Main::CFP_POST_TYPE_NAME_ITEM === $post_type ||
			is_post_type_archive(
				[
					Main::CFP_POST_TYPE_NAME_ITEM_LIST,
					Main::CFP_POST_TYPE_NAME_ITEM,
				]
			)
		) {
			wp_enqueue_script( $this->plugin_name, plugin_dir_url( __FILE__ ) . 'js/comdev-files-admin.js', [ 'jquery' ], $this->version, false );

			/** Load UIKIT */
			wp_enqueue_script( 'cfp_uikit', plugin_dir_url( __FILE__ ) . 'js/uikit.min.js', [ 'jquery' ], '3.0.0.30', true );
			wp_enqueue_script( 'cfp_uikit-icons', plugin_dir_url( __FILE__ ) . 'js/uikit-icons.min.js', [ 'jquery' ], '3.0.0.30', true );
		}
	}

	/**
	 * Add menu
	 *
	 * @return void
	 */
	public function add_menu(): void {
		add_menu_page(
			$this->plugin_name,
			__( 'Comdev -> Downloads', 'comdev-files' ),
			'administrator',
			$this->plugin_name,
			[ $this, 'display_admin_dashboard' ],
			plugin_dir_url( __FILE__ ) . '/images/icon_24.png',
			26
		);

		add_submenu_page(
			$this->plugin_name,
			__( 'Dashboard', 'comdev-files' ),
			__( 'Dashboard', 'comdev-files' ),
			'manage_options',
			$this->plugin_name,
			[ $this, 'display_admin_dashboard' ]
		);

		add_submenu_page(
			$this->plugin_name,
			__( 'Downloads Lists', 'comdev-files' ),
			__( 'Download Lists', 'comdev-files' ),
			'edit_posts',
			'/edit.php?post_type=' . Main::CFP_POST_TYPE_NAME_ITEM_LIST
		);

		add_submenu_page(
			$this->plugin_name,
			__( 'Downloads Items', 'comdev-files' ),
			__( 'Download Items', 'comdev-files' ),
			'edit_posts',
			'/edit.php?post_type=' . Main::CFP_POST_TYPE_NAME_ITEM
		);

		add_submenu_page(
			$this->plugin_name,
			__( 'Templates', 'comdev-files' ),
			__( 'Templates', 'comdev-files' ),
			'manage_options',
			$this->plugin_name . '-templates',
			[ $this, 'display_admin_templates' ]
		);

		add_submenu_page(
			$this->plugin_name,
			__( 'Settings', 'comdev-files' ),
			__( 'Settings', 'comdev-files' ),
			'manage_options',
			$this->plugin_name . '-settings',
			[ $this, 'display_admin_settings' ]
		);
	}

	/**
	 * Display admin dashboard.
	 *
	 * @return void
	 */
	public function display_admin_dashboard(): void {
		require_once 'partials/' . $this->plugin_name . '-admin-display.php';
	}

	/**
	 * Display admin settings.
	 *
	 * @return void
	 */
	public function display_admin_settings(): void {
		require_once 'partials/' . $this->plugin_name . '-admin-settings-display.php';
	}

	/**
	 * Display admin templates.
	 *
	 * @return void
	 */
	public function display_admin_templates(): void {

		$getdata = new Comdev_Files_Admin_Templates();

		$data  = $getdata->get_templates_from_database();
		$data2 = $getdata->get_templates_packages_from_database();

		require_once 'partials/' . $this->plugin_name . '-admin-templates.php';
	}
}
