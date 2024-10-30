<?php
/**
 * Db helpers class.
 *
 * @package comdev/files
 */

namespace Comdev\Files\Helpers;

use Comdev\Files\Main;

/**
 * DBHelpers class file.
 */
class DBHelpers {

	/**
	 * Get template by id.
	 *
	 * @param int $template_id Template id.
	 *
	 * @return string
	 */
	public static function get_template_by_id( int $template_id ) {
		global $wpdb;

		$table_name = $wpdb->prefix . Main::CFP_TEMPLATE_TABLE_NAME;
		// phpcs:disable
		$results = $wpdb->get_results(
			$wpdb->prepare( "SELECT * FROM $table_name WHERE id = %d", $template_id )
		);
		// phpcs:enable

		if ( empty( $results ) ) {
			return '';
		}

		return $results[0]->template_data;
	}

	/**
	 * Get templates to select options.
	 *
	 * @return array
	 */
	public static function get_templates_to_select(): array {
		global $wpdb;
		$table_name = $wpdb->prefix . Main::CFP_TEMPLATE_TABLE_NAME;

		// phpcs:disable
		$results = $wpdb->get_results( 'SELECT * FROM ' . $table_name );
		// phpcs:enable

		if ( empty( $results ) ) {
			return [ '0' => __( 'Default Template', 'comdev-files' ) ];
		}
		$templates = [ '0' => __( 'Default Template', 'comdev-files' ) ];
		foreach ( $results as $template ) {
			$templates[ $template->id ] = $template->template_title;
		}

		return $templates;
	}

	/**
	 * Get listing id by item id.
	 *
	 * @param int $item_id Item id.
	 *
	 * @return array|object|\stdClass[]|string
	 */
	public static function get_lists_id_by_item_id( int $item_id ) {
		global $wpdb;

		$table_name = $wpdb->prefix . 'postmeta';
		// phpcs:disable
		$results = $wpdb->get_results(
			$wpdb->prepare( "SELECT post_id FROM $table_name WHERE meta_key LIKE '%_cfp_files_list|||%|id' AND meta_value = '%d'", $item_id )
		);
		// phpcs:enable

		if ( empty( $results ) ) {
			return '';
		}

		return $results;
	}

	public static function get_product_id_by_listing_id( int $listing_id ) {
		global $wpdb;

		$table_name = $wpdb->prefix . 'postmeta';
		// phpcs:disable
		$results = $wpdb->get_results(
			$wpdb->prepare( "SELECT post_id FROM $table_name WHERE meta_key = '_cfp_download_listing_product' AND meta_value = '%d'", $listing_id )
		);
		// phpcs:enable

		if ( empty( $results ) ) {
			return '';
		}

		return $results;
	}
}
