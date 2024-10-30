<?php
/**
 * Preview template.
 *
 * @package comdev/files
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

do_action( 'comdev_files_display_admin_header' );
?>
<div class="comdev-files-templates dashboard uk-padding">
	<div class="uk-card uk-card-default uk-card-body uk-width-1-1@m">
		<table class="uk-table">
			<thead>
			<tr>
				<th><?php echo esc_html( __( 'ID', 'comdev-files' ) ); ?></th>
				<th><?php echo esc_html( __( 'Template Name', 'comdev-files' ) ); ?></th>
				<th><?php echo esc_html( __( 'Template ID', 'comdev-files' ) ); ?></th>
				<th><?php echo esc_html( __( 'Status', 'comdev-files' ) ); ?></th>
				<th><?php echo esc_html( __( 'Preview', 'comdev-files' ) ); ?></th>
				<!-- Add more columns as needed -->
			</tr>
			</thead>
			<tbody>
			<?php
			if ( ! empty( $data ) ) {
				foreach ( $data as $row ) {
					?>
					<tr>
						<td><?php echo esc_html( $row->id ); ?></td>
						<td><strong><?php echo esc_html( $row->template_title ); ?></strong></td>
						<td><?php echo esc_html( $row->template_id ); ?></td>
						<td><?php echo esc_html( $row->template_status ); ?></td>
						<td>
							<a
									href="#<?php echo esc_html( $row->template_id ); ?>"
									class="uk-button uk-button-small uk-button-primary"
									uk-toggle="target: #<?php echo esc_html( $row->template_id ); ?>">
								<?php echo esc_html( __( 'Preview', 'comdev-files' ) ); ?>
							</a>
						</td>
					</tr>


					<?php
				}
			}
			?>
			</tbody>
		</table>
	</div>
</div>
<?php
if ( ! empty( $data ) ) {
	foreach ( $data as $row ) {
		?>

		<div id="<?php echo esc_html( $row->template_id ); ?>" uk-modal>
			<div class="uk-modal-dialog uk-modal-body">
				<h2 class="uk-modal-title">
					<?php echo esc_html( $row->template_title ); ?>
				</h2>
				<div class="uk-display-block">
					<table class="cd-tbl-<?php echo esc_html( $row->template_id ); ?>">
						<thead>
						<tr>
							<th scope="col"><?php esc_html_e( 'Name', 'comdev-files' ); ?></th>
							<th scope="col"><?php esc_html_e( 'Version', 'comdev-files' ); ?></th>
							<th scope="col"><?php esc_html_e( 'Size', 'comdev-files' ); ?></th>
						</tr>
						</thead>
						<tbody class="cd-files-table-body">
						<tr>
							<td><a href="#"><?php esc_html_e( 'File 1 to download', 'comdev-files' ); ?></a></td>
							<td><?php esc_html_e( '1.0', 'comdev-files' ); ?></td>
							<td><?php esc_html_e( '40 KB', 'comdev-files' ); ?></td>
						</tr>
						<tr>
							<td><a href="#"><?php esc_html_e( 'File 2 to download', 'comdev-files' ); ?></a></td>
							<td><?php esc_html_e( '1.0', 'comdev-files' ); ?></td>
							<td><?php esc_html_e( '140 KB', 'comdev-files' ); ?></td>
						</tr>
						</tbody>
					</table>
				</div>
				<button class="uk-button uk-button-default uk-margin-top uk-modal-close" type="button">
					<?php echo esc_html( __( 'Close', 'comdev-files' ) ); ?>
				</button>
			</div>
		</div>
		<?php
	}
}
?>
