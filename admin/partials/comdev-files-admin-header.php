<?php

/**
 * Header template.
 *
 * @package comdev/files
 */
if ( !defined( 'ABSPATH' ) ) {
    exit;
}
if ( empty( $css_cust_post ) ) {
    $css_cust_post = 'comdev-header';
}
?>
<div class="comdev-files-header <?php 
echo esc_html( $css_cust_post );
?> uk-flex uk-flex-middle uk-background-default">
	<div class="comdev-files-logo">
		<div class="uk-card uk-card-primary uk-padding-remove">
			<img
					class="comdev-logo"
					src="<?php 
echo esc_url( plugin_dir_url( dirname( __FILE__ ) ) . 'images/logo_comdev.png' );
?>">
		</div>
	</div>
	<div class="comdev-files-logo-text uk-width-expand@m uk-flex-middle uk-margin-left">
		<h1 class="uk-h4 strong uk-padding-remove uk-margin-remove uk-padding-small-top">
			<?php 
esc_html_e( 'Comdev Downloads', 'comdev-files' );
?>
		</h1>
	</div>
	<div class="uk-margin-right">
		<div class="comdev-files-mode-selector">
			<span class="uk-h5">
				<?php 
global $comdev_files_cd_fs;
esc_html_e( 'L i t e', 'comdev-files' );
?>

			</span>
		</div>
	</div>
</div>
