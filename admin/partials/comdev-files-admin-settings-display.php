<?php
/**
 * Provide a admin area view for the plugin
 *
 * This file is used to markup the admin-facing aspects of the plugin.
 *
 * @link       https://comdev.eu/wordpress-plugins/wordpress-download-plugin
 * @since      1.0.0
 *
 * @package    Comdev_Files
 * @subpackage Comdev_Files/admin/partials
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly.

do_action( 'comdev_files_display_admin_header' );
?>

<div class="comdev-files-settings dashboard uk-padding">
	<div class="uk-card uk-card-default uk-card-body uk-width-1-1@m">
		<?php settings_errors(); ?>
		<form method="POST" action="options.php">
			<?php
			settings_fields( $this->plugin_name );
			do_settings_sections( $this->plugin_name );
			submit_button();
			?>
		</form>
	</div>
</div>
