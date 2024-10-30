<?php

/**
 * Main class.
 *
 * @package comdev/files
 */
namespace Comdev\Files;

use Carbon_Fields\Carbon_Fields;
use Comdev\Files\Helpers\DBHelpers;
use Comdev\Files\Helpers\FrontEndHelpers;
use WC_Data_Store;
use WC_Product_Download;
/**
 * Main class file.
 */
class Main {
    /**
     * Plugin prefix.
     */
    const CFP_PLUGIN_PREFIX = 'cfp_';

    /**
     * Custom post type name download items.
     */
    const CFP_POST_TYPE_NAME_ITEM = 'download_items';

    /**
     * Custom post type name download lists.
     */
    const CFP_POST_TYPE_NAME_ITEM_LIST = 'download_list';

    /**
     * Short code name.
     */
    const CFP_SHORT_CODE_NAME_ITEM = 'comdev_download';

    /**
     * Table name template.
     */
    const CFP_TEMPLATE_TABLE_NAME = 'cdf_downloads';

    /**
     * Main construct.
     */
    public function __construct() {
        $this->init();
    }

    /**
     * Init hooks and action.
     *
     * @return void
     */
    private function init() : void {
        global $comdev_files_cd_fs;
        add_action( 'after_setup_theme', [$this, 'crb_load'] );
        add_filter(
            'carbon_fields_should_save_field_value',
            [$this, 'save_post_list_save'],
            10,
            3
        );
        add_filter( 'manage_' . self::CFP_POST_TYPE_NAME_ITEM_LIST . '_posts_columns', [$this, 'add_custom_columns'] );
        add_action(
            'manage_' . self::CFP_POST_TYPE_NAME_ITEM_LIST . '_posts_custom_column',
            [$this, 'short_code_columns_handler'],
            10,
            2
        );
        add_action( 'in_admin_header', [$this, 'show_plugin_header'] );
        add_filter(
            'woocommerce_order_data_store_cpt_get_orders_query',
            [$this, 'handle_custom_query_var'],
            10,
            2
        );
        add_filter(
            'carbon_fields_should_save_field_value',
            [$this, 'handler_save_item_file'],
            10,
            3
        );
        new PluginCarbonFields();
        new ShortCode();
        add_option( 'comdev_files_setting_show_ver', true );
        add_option( 'comdev_files_setting_show_size', true );
        add_option( 'comdev_files_setting_user_access', true );
    }

    /**
     * Load carbone fields.
     *
     * @return void
     */
    public function crb_load() : void {
        Carbon_Fields::boot();
    }

    /**
     * Save post lists.
     *
     * @param bool  $save  Save.
     * @param array $value Field value.
     * @param mixed $field Field Class.
     *
     * @return mixed
     */
    public function save_post_list_save( $save, $value, $field ) {
        if ( self::CFP_PLUGIN_PREFIX . 'short_code' === $field->get_base_name() ) {
            global $post_id;
            $lists = carbon_get_post_meta( $post_id, self::CFP_PLUGIN_PREFIX . 'files_list' );
            $template_name = carbon_get_post_meta( $post_id, self::CFP_PLUGIN_PREFIX . 'template_name' );
            $date_expiry = carbon_get_post_meta( $post_id, self::CFP_PLUGIN_PREFIX . 'expiry_download' );
            if ( !empty( $lists ) ) {
                $short_code = '[';
                $short_code .= self::CFP_SHORT_CODE_NAME_ITEM . ' list-id="' . $post_id . '"';
                $short_code .= ( !empty( $template_name ) ? ' template-id="' . $template_name . '" ' : '' );
                $short_code .= ( !empty( $date_expiry ) ? ' date-expiry="' . $date_expiry . '" ' : '' );
                $short_code .= ']';
                $field->set_value( $short_code );
                return $short_code;
            }
        }
        return $value;
    }

    /**
     * Add custom columns.
     *
     * @param array $columns Columns.
     *
     * @return array
     */
    public function add_custom_columns( array $columns ) : array {
        $columns['short_code'] = __( 'Short code', 'comdev-files' );
        $last_element = array_pop( $columns );
        array_splice(
            $columns,
            2,
            0,
            $last_element
        );
        return $columns;
    }

    /**
     * Output short code column content.
     *
     * @param string|int $column  Column name.
     * @param int        $post_id Post id.
     *
     * @return void
     */
    public function short_code_columns_handler( $column, int $post_id ) : void {
        $short_code = carbon_get_post_meta( $post_id, self::CFP_PLUGIN_PREFIX . 'short_code' );
        ?>
		<input
				class="large-text code"
				type="text" onfocus="this.select();"
				readonly="readonly"
				value="<?php 
        echo esc_attr( $short_code ?? 'Not Short code' );
        ?>">
		<?php 
    }

    /**
     * Add header in Custom post type.
     *
     * @return void
     */
    public function show_plugin_header() : void {
        global $post_type;
        if ( self::CFP_POST_TYPE_NAME_ITEM === $post_type || self::CFP_POST_TYPE_NAME_ITEM_LIST === $post_type ) {
            $css_cust_post = 'comdev-files-header-incl';
            require plugin_dir_path( dirname( __FILE__ ) ) . '../admin/partials/comdev-files-admin-header.php';
        }
    }

    /**
     * Update downloadable files in order.
     *
     * @param int   $product_id         Product ID.
     * @param array $downloadable_files Files Array [WC_Product_Download].
     *
     * @return void
     */
    private function update_downloadable_files_in_orders( int $product_id, array $downloadable_files ) : void {
        $args = [
            'limit'      => -1,
            'product_id' => $product_id,
        ];
        $orders = wc_get_orders( $args );
        foreach ( $orders as $order ) {
            foreach ( $order->get_items() as $item ) {
                if ( $item->get_product_id() === $product_id ) {
                    $data_store = WC_Data_Store::load( 'customer-download' );
                    $data_store->delete_by_order_id( $order->ID );
                    foreach ( $downloadable_files as $key => $downloadable_file ) {
                        wc_downloadable_file_permission( $key, $item->get_product_id(), $order );
                    }
                }
            }
        }
    }

    /**
     * Handle a custom 'customvar' query var to get orders with the 'customvar' meta.
     *
     * @param array $query      - Args for WP_Query.
     * @param array $query_vars - Query vars from WC_Order_Query.
     *
     * @return array modified $query
     */
    public function handle_custom_query_var( $query, $query_vars ) {
        if ( !empty( $query_vars['customvar'] ) ) {
            $query['meta_query'][] = [
                'key'   => '_product_id',
                'value' => esc_attr( $query_vars['product_id'] ),
            ];
        }
        return $query;
    }

    /**
     * Handler save item file.
     *
     * @param bool  $save  Bool Saved.
     * @param mixed $value Field value.
     * @param mixed $field Fields class.
     *
     * @return mixed
     */
    public function handler_save_item_file( $save, $value, $field ) {
        global $post_ID;
        if ( '_cfp_file_item' === $field->get_name() ) {
            $lists_id = DBHelpers::get_lists_id_by_item_id( $post_ID );
            foreach ( $lists_id as $list_id ) {
                $pod_id = DBHelpers::get_product_id_by_listing_id( $list_id->post_id );
                foreach ( $pod_id as $p_id ) {
                    $product = wc_get_product( $p_id->post_id );
                    if ( empty( $product ) ) {
                        continue;
                    }
                    $listing = carbon_get_post_meta( $list_id->post_id, self::CFP_PLUGIN_PREFIX . 'files_list' );
                    if ( empty( $listing ) ) {
                        continue;
                    }
                    if ( !empty( $existing_downloads ) ) {
                        $product->set_downloads( [] );
                    }
                    $downloadable_file_array = [];
                    foreach ( $listing as $item ) {
                        $file_id = carbon_get_post_meta( $item['id'], self::CFP_PLUGIN_PREFIX . 'file_item' );
                        if ( empty( $file_id ) ) {
                            $file_id = $value;
                        }
                        $file_url = wp_get_attachment_url( $file_id );
                        $download_id = md5( $file_url );
                        $pd_object = new WC_Product_Download();
                        $pd_object->set_id( $download_id );
                        $pd_object->set_name( basename( $file_url ) );
                        $pd_object->set_file( $file_url );
                        $downloadable_file_array[$download_id] = $pd_object;
                    }
                    $product->set_downloadable( true );
                    $product->set_downloads( $downloadable_file_array );
                    if ( !empty( $carbon_fields_data['_cfp_expiry_download'] ) ) {
                        $product->set_download_expiry( FrontEndHelpers::get_download_expiry__premium_only( $carbon_fields_data['_cfp_expiry_download'] ) );
                    }
                    $product->save();
                    $this->update_downloadable_files_in_orders( $product->get_id(), $downloadable_file_array );
                }
            }
        }
        return $value;
    }

}
