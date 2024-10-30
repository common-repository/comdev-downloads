<?php
/**
 * Admin Settings Class.
 *
 * @package    Comdev_Files
 * @subpackage Comdev_Files/admin
 * @author     Comdev <comdev@aa.com>
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
} // Exit if accessed directly.

if ( ! class_exists( 'Comdev_Files_Admin_Settings' ) ) {

	/**
	 * Comdev_Files_Admin_Settings class.
	 */
	class Comdev_Files_Admin_Settings extends Comdev_Files_Admin {

		/**
		 * Option name.
		 *
		 * @var string
		 */
		private $option_name = 'comdev_files_setting';

		/**
		 * Comdev_Files_Admin_Settings construct.
		 */
		public function __construct() {

			$plugin_name = 'comdev-files';

			$this->plugin_name = $plugin_name;

			add_action( 'admin_init', [ $this, 'register_comdev_files_plugin_settings' ] );
		}

		/**
		 * Register settings page.
		 *
		 * @return void
		 */
		public function register_comdev_files_plugin_settings(): void {
			register_setting( $this->plugin_name, $this->option_name . '_file_ext', 'string' );
			register_setting( $this->plugin_name, $this->option_name . '_file_template', 'boolean' );
			register_setting( $this->plugin_name, $this->option_name . '_show_ver', 'boolean' );
			register_setting( $this->plugin_name, $this->option_name . '_show_size', 'boolean' );
			register_setting( $this->plugin_name, $this->option_name . '_file_info', 'string' );

			// Add a General section.
			add_settings_section(
				$this->option_name . '_general',
				__( 'General Settings', 'comdev-files' ),
				[ $this, $this->option_name . '_general_cb' ],
				$this->plugin_name
			);

			add_settings_field(
				$this->option_name . '_user_access',
				__( 'Download Permissions', 'comdev-files' ),
				[ $this, $this->option_name . '_user_access_cb' ],
				$this->plugin_name,
				$this->option_name . '_general',
				[ 'label_for' => $this->option_name . '_user_access' ]
			);

			add_settings_field(
				$this->option_name . '_file_ext',
				__( 'Allowed File Extensions', 'comdev-files' ),
				[ $this, $this->option_name . '_file_ext_cb' ],
				$this->plugin_name,
				$this->option_name . '_general',
				[ 'label_for' => $this->option_name . '_file_ext' ]
			);

			add_settings_field(
				$this->option_name . '_show_ver',
				__( 'Display file version', 'comdev-files' ),
				[ $this, $this->option_name . '_show_ver_cb' ],
				$this->plugin_name,
				$this->option_name . '_general',
				[ 'label_for' => $this->option_name . '_show_ver' ]
			);

			add_settings_field(
				$this->option_name . '_show_size',
				__( 'Display file size', 'comdev-files' ),
				[ $this, $this->option_name . '_show_size_cb' ],
				$this->plugin_name,
				$this->option_name . '_general',
				[ 'label_for' => $this->option_name . '_show_size' ]
			);

			add_settings_field(
				$this->option_name . '_file_info',
				__( 'Terms and Conditions', 'comdev-files' ),
				[ $this, $this->option_name . '_file_info_cb' ],
				$this->plugin_name,
				$this->option_name . '_general',
				[ 'label_for' => $this->option_name . '_file_info' ]
			);

			register_setting(
				$this->plugin_name,
				$this->option_name . '_user_access',
				[
					$this,
					$this->option_name . '_sanitize_user_access',
				]
			);
		}

		/**
		 * Show general Settings and options.
		 *
		 * @return void
		 */
		public function comdev_files_setting_general_cb(): void {
			?>
			<p>
				<span uk-icon="icon: settings;" class="uk-padding-small"> </span>
				<?php echo esc_html( __( 'General Settings and options', 'comdev-files' ) ); ?>
			</p>
			<?php
		}

		/**
		 * Show file ext field.
		 *
		 * @return void
		 */
		public function comdev_files_setting_file_ext_cb(): void {
			$val = get_option( $this->option_name . '_file_ext' );
			?>
			<input
					type="text"
					name="<?php echo esc_attr( $this->option_name . '_file_ext' ); ?>"
					id="<?php echo esc_attr( $this->option_name . '_file_ext' ); ?>"
					value="<?php echo esc_attr( $val ?? '' ); ?>"
					placeholder="jpg,gif,zip,pdf">
			<p class='uk-text-muted'><?php echo esc_html( __( 'Comma separated file extensions', 'comdev-files' ) ); ?></p>
			<?php
		}

		/**
		 * Show download permission option.
		 *
		 * @return void
		 */
		public function comdev_files_setting_user_access_cb(): void {
			$val = get_option( $this->option_name . '_user_access' );
			?>
			<fieldset>
				<label>
					<input
							type="radio"
							name="<?php echo esc_attr( $this->option_name . '_user_access' ); ?>"
							id="<?php echo esc_attr( $this->option_name . '_user_access' ); ?>"
							value="true"
						<?php checked( $val, 'true' ); ?>>
					<?php esc_html_e( 'Logged In Users', 'comdev-files' ); ?>
				</label>
				<br>
				<label>
					<input
							type="radio"
							name="<?php echo esc_attr( $this->option_name . '_user_access' ); ?>"
							value="false"
						<?php checked( $val, 'false' ); ?>>
					<?php esc_html_e( 'All', 'comdev-files' ); ?>
				</label>
			</fieldset>
			<?php
		}

		/**
		 * Show display file version option.
		 *
		 * @return void
		 */
		public function comdev_files_setting_show_ver_cb() {
			$optionsver = get_option( $this->option_name . '_show_ver' );
			?>
			<input
					type="checkbox"
					name="<?php echo esc_attr( $this->option_name . '_show_ver' ); ?>"
					id="<?php echo esc_attr( $this->option_name . '_show_ver' ); ?>"
					value="1" <?php checked( 1, $optionsver ?? '' ); ?> >
			<?php

		}

		/**
		 * Show display file size option.
		 *
		 * @return void
		 */
		public function comdev_files_setting_show_size_cb(): void {
			$optionsize = get_option( $this->option_name . '_show_size' );
			?>
			<input
					type="checkbox"
					name="<?php echo esc_attr( $this->option_name . '_show_size' ); ?>"
					id="<?php echo esc_attr( $this->option_name . '_show_size' ); ?>"
				<?php checked( 1, $optionsize ?? '' ); ?>
					value="1">
			<?php
		}

		/**
		 * Show info terms and conditions filed settings.
		 *
		 * @return void
		 */
		public function comdev_files_setting_file_info_cb(): void {
			$options = get_option( $this->option_name . '_file_info' );
			?>
			<textarea
					id='<?php echo esc_attr( $this->option_name . '_file_info' ); ?>'
					name='<?php echo esc_attr( $this->option_name . '_file_info' ); ?>'
					rows='7'
					cols='50'
					type='textarea'><?php echo esc_html( $options ?? '' ); ?></textarea>
			<?php
		}
	}
}

return new Comdev_Files_Admin_Settings();

