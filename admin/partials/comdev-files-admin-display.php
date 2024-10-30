<?php

/**
 * Dashboard template.
 *
 * @package comdev/files
 */
use Comdev\Files\Helpers\FrontEndHelpers;
if ( !defined( 'ABSPATH' ) ) {
    exit;
}
// Exit if accessed directly.
do_action( 'comdev_files_display_admin_header' );
global $comdev_files_cd_fs;
?>
<div class="comdev-files-dashboard dashboard uk-padding uk-margin-large-bottom">

	<?php 
do_action( 'comdev_files_display_admin_notifications' );
?>

	<div class="uk-grid uk-margin-medium-top">
		<div class="uk-width-1-1@m">
			<div class="uk-card uk-card-default uk-card-body uk-width-1-1@m">
				<h3 class="uk-card-title">
					<span uk-icon="icon: cog; ratio 4"></span>
					<?php 
esc_attr_e( 'Dashboard', 'comdev-files' );
?>
				</h3>
				<h5>
					<?php 
echo wp_kses_post( __( 'With Comdev Downloads you may upload, share Download List Packages across Blog and Post Pages, Widgets and much more. <br /><strong>Upgrade</strong> to <strong><a href="admin.php?page=comdev-files-pricing">PRO</a></strong> version to unlock advanced features such like <strong>Download Expiration</strong> or the ability to <strong>Sell Downloads within Woocommerce Product.</strong>', 'comdev-files' ) );
?>
				</h5>
			</div>
		</div>
	</div>

	<div class="uk-grid uk-margin-medium-top">
		<div class="uk-width-1-2@m">
			<div class="uk-card uk-card-default uk-card-body">
				<h3 class="uk-card-title">
					<?php 
esc_attr_e( 'Next Steps', 'comdev-files' );
?>
				</h3>
				<?php 
?>
					<div>
						<h5>
							<?php 
esc_html_e( 'Upgrade to PRO', 'comdev-files' );
?>
						</h5>
						<a
								href="<?php 
echo esc_url( admin_url( 'admin.php?page=comdev-files-pricing' ) );
?>"
								class="uk-button uk-button-primary-magenta">
							UPGRADE TO <strong>PRO</strong>
							<span uk-icon="icon: bolt"></span>
						</a>
						<p class="">
							<?php 
esc_html_e( 'Get more features, like download expiry, products integration and much more', 'comdev-files' );
?>
						</p>
					</div>
				<?php 
?>
				<hr/>
				<div>
					<h5><?php 
esc_html_e( 'Get Started', 'comdev-files' );
?> </h5>
					<p><?php 
esc_html_e( 'Start creating your own file packages and publish them on your website.', 'comdev-files' );
?> </p>
				</div>

			</div>
			<div class="uk-card uk-card-body uk-padding-small comdev-files-wrap-footer">
				<p class="uk-text-small">
					COMDEV FILES: VER.<?php 
echo esc_html( COMDEV_FILES_VERSION );
?> |
					<a href="#" uk-toggle="target: #changelog">
						CHANGELOG
					</a>
				</p>
			</div>
		</div>
		<div class="uk-width-1-2@m">
			<div class="uk-card uk-card-primary uk-card-body comdev-files-stats">
				<h5 class="uk-margin-small-bottom">
					<span uk-icon="icon: file-text"></span>
					<?php 
esc_html_e( 'Total Files', 'comdev-files' );
?>:
					<span class="cd-file-number"><?php 
echo esc_html( FrontEndHelpers::get_total_files() );
?></span>
				</h5>
				<hr/>
				<h5 class="uk-margin-small-bottom uk-margin-remove-top">
					<span uk-icon="icon: album"></span>
					<?php 
esc_html_e( 'Total Packages', 'comdev-files' );
?>:
					<span class="cd-file-number"><?php 
echo esc_html( FrontEndHelpers::get_total_packages() );
?></span>
				</h5>
				<hr/>
				<div class="uk-hidden">
					<h5 class="uk-margin-small-bottom uk-margin-remove-top">
						<span uk-icon="icon: cloud-download"></span>
						<?php 
esc_html_e( 'Most Downloaded', 'comdev-files' );
?>
					</h5>
					<table>
						<tr>
							<th></th>
						</tr>
						<tr>
							<td>File1.pdf</td>
							<td>100</td>
						</tr>
					</table>
				</div>
			</div>
			<div class="uk-card uk-card-default uk-card-body uk-margin-top">
				<h3 class="uk-card-title"><?php 
esc_html_e( 'Links', 'comdev-files' );
?></h3>
				<div>
					<h5>
						<span uk-icon="icon: file-pdf"></span>
						<?php 
esc_html_e( 'Documentation', 'comdev-files' );
?>
					</h5>
					<p><?php 
esc_html_e( 'Looking for more details? Check out', 'comdev-files' );
?> <a
								href="https://wiki.comdev.eu/books/wordpress-plugins" target="_blank">Documentation</a>
					</p>
				</div>

				<div>
					<h5>
						<span uk-icon="icon: commenting"></span>
						<?php 
esc_html_e( 'Support', 'comdev-files' );
?>
					</h5>
					<p><?php 
esc_html_e( 'Direct help from our qualified support team.', 'comdev-files' );
?></p>
				</div>
			</div>
		</div>
	</div>
</div>

<div id="changelog" uk-modal>
	<div class="uk-modal-dialog uk-modal-body">
		<h2 class="uk-modal-title">
			Changelog
		</h2>
		<div class="uk-display-block">
			<h5>1.0.0</h5>
			<p>Plugin Release</p>
		</div>
		<button class="uk-button uk-button-default uk-margin-top uk-modal-close" type="button">
			<?php 
echo esc_html( __( 'Close', 'comdev-files' ) );
?>
		</button>
	</div>
</div>
