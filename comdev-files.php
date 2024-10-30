<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 *
 * @link              https://comdev.eu/wordpress-plugins/wordpress-download-plugin
 * @since             1.0.0
 * @package           Comdev_Files
 *
 * @wordpress-plugin
 * Plugin Name:       Comdev Downloads
 * Plugin URI:        https://comdev.eu/wordpress-plugins/wordpress-download-plugin
 * Description:       With Comdev Downloads, you can share downloadable content across your WordPress website.
 * Version:           1.1.0
 * Author:            Comdev
 * Author URI:        https://comdev.eu
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       comdev-files
 * Domain Path:       /languages
 */
if ( !function_exists( 'comdev_files_cd_fs' ) ) {
    /**
     * Create a helper function for easy SDK access.
     *
     * @return Freemius
     */
    function comdev_files_cd_fs() {
        global $comdev_files_cd_fs;
        if ( !isset( $comdev_files_cd_fs ) ) {
            // Include Freemius SDK.
            require_once dirname( __FILE__ ) . '/freemius/start.php';
            $comdev_files_cd_fs = fs_dynamic_init( [
                'id'             => '15614',
                'slug'           => 'comdev-downloads',
                'type'           => 'plugin',
                'public_key'     => 'pk_aff8485913a8f6d114e69a7a164e4',
                'is_premium'     => false,
                'has_addons'     => false,
                'has_paid_plans' => true,
                'menu'           => [
                    'slug'    => 'comdev-files',
                    'contact' => false,
                    'support' => false,
                ],
                'is_live'        => true,
            ] );
        }
        return $comdev_files_cd_fs;
    }

    // Init Freemius.
    comdev_files_cd_fs();
    // Signal that SDK was initiated.
    do_action( 'comdev_files_cd_fs_loaded' );
}
// If this file is called directly, abort.
if ( !defined( 'WPINC' ) ) {
    die;
}
// If this file is called directly, abort.
if ( !defined( 'WPINC' ) ) {
    die;
}
/**
 * Currently plugin version.
 * Start at version 1.0.0 and use SemVer - https://semver.org
 * Rename this for your plugin and update it as you release new versions.
 */
define( 'COMDEV_FILES_VERSION', '1.1.0' );
/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-comdev-files-activator.php
 *
 * @return void
 */
function cdfp_activate_comdev_files() : void {
    require_once plugin_dir_path( __FILE__ ) . 'includes/class-comdev-files-activator.php';
    Comdev_Files_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-comdev-files-deactivator.php
 *
 * @return void
 */
function cdfp_deactivate_comdev_files() : void {
    require_once plugin_dir_path( __FILE__ ) . 'includes/class-comdev-files-deactivator.php';
    Comdev_Files_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'cdfp_activate_comdev_files' );
register_deactivation_hook( __FILE__, 'cdfp_deactivate_comdev_files' );
/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-comdev-files.php';
/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @return void
 * @since    1.0.0
 */
function cdfp_run_comdev_files() : void {
    $plugin = new Comdev_Files();
    $plugin->run();
}

cdfp_run_comdev_files();