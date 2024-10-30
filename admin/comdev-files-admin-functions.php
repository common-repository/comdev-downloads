<?php
/**
 * Plugin Name Admin Functions
 *
 * @author        Comdev
 * @category      Core
 * @package       Comdev/Files/Functions
 * @version       1.0.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly


/**
 * Display admin header.
 *
 * @return void
 */
function comdev_files_display_admin_header_view(): void {
	require_once 'partials/comdev-files-admin-header.php';
}

add_action( 'comdev_files_display_admin_header', 'comdev_files_display_admin_header_view', 10 );

/**
 * Display admin notifications.
 *
 * @return void
 */
function comdev_files_display_admin_notifications_view(): void {
	$notifications_activate = get_option( 'comdev_files_notifications_activate', false );
	if ( ! $notifications_activate ) {
		require_once 'partials/comdev-files-admin-notifications.php';
		update_option( 'comdev_files_notifications_activate', true );
	}
}

add_action( 'comdev_files_display_admin_notifications', 'comdev_files_display_admin_notifications_view', 10 );

/**
 * Add css body class.
 *
 * @param string $classes Classes.
 *
 * @return string
 */
function comdev_files_add_css_body( string $classes ) {
	return $classes . ' comdev-files';
}

add_action( 'admin_body_class', 'comdev_files_add_css_body' );
