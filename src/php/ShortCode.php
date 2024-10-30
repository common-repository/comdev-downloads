<?php
/**
 * Short code class.
 *
 * @package comdev/files
 */

namespace Comdev\Files;

use Comdev\Files\Helpers\DBHelpers;
use Comdev\Files\Helpers\FrontEndHelpers;

/**
 * ShortCode class file.
 */
class ShortCode {
	/**
	 * ShortCode construct.
	 */
	public function __construct() {
		$this->init();
	}

	/**
	 * Init hooks and actions.
	 *
	 * @return void
	 */
	public function init(): void {
		add_shortcode( Main::CFP_SHORT_CODE_NAME_ITEM, [ $this, 'show_short_code' ] );
	}

	/**
	 * Show short code.
	 *
	 * @param array $atts Attributes.
	 *
	 * @return string
	 */
	public function show_short_code( $atts ): string {
		$list_id     = $atts['list-id'] ?? null;
		$template_id = $atts['template-id'] ?? null;
		$date_expiry = $atts['date-expiry'] ?? null;

		ob_start();

		if ( empty( $list_id ) ) {
			return __( 'Not set list ID', 'comdev-files' );
		}

		if ( empty( $date_expiry ) ) {
			$date_expiry = carbon_get_post_meta( $list_id, Main::CFP_PLUGIN_PREFIX . 'expiry_download' );
		}

		if ( empty( $template_id ) ) {
			$template_id = 1;
		}

		$lists_id = carbon_get_post_meta( $list_id, Main::CFP_PLUGIN_PREFIX . 'files_list' );

		$template = DBHelpers::get_template_by_id( $template_id );

		$content = FrontEndHelpers::get_listing_content( $lists_id, $template, $date_expiry );

		echo wp_kses_post( $content );

		return ob_get_clean();
	}
}
