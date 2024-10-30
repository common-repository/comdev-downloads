<?php
/**
 * Activate plugin notification template.
 *
 * @package comdev/files
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly.
?>
<div class="uk-alert-primary" uk-alert>
	<a href class="uk-alert-close" uk-close></a>
	<p><?php esc_html_e( 'Plugin has been installed and activated.', 'comdev-files' ); ?></p>
</div>
