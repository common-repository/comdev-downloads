<?php

/**
 * Init Carbon fields.
 *
 * @package comdev/files
 */
namespace Comdev\Files;

use Carbon_Fields\Container;
use Carbon_Fields\Field;
use Comdev\Files\Helpers\DBHelpers;
use Comdev\Files\Helpers\FrontEndHelpers;
/**
 * PluginCarbonFields class file.
 */
class PluginCarbonFields {
    /**
     * PluginCarbonFields construct.
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
        add_action( 'carbon_fields_register_fields', [$this, 'add_fields_to_download_items'] );
        add_action( 'carbon_fields_register_fields', [$this, 'add_fields_to_download_lists'] );
        add_action( 'carbon_fields_register_fields', [$this, 'add_fields_to_product'] );
    }

    /**
     * Add carbon fields to cpt download items.
     *
     * @return void
     */
    public function add_fields_to_download_items() : void {
        Container::make( 'post_meta', __( 'Upload File', 'comdev-files' ) )->where( 'post_type', '=', Main::CFP_POST_TYPE_NAME_ITEM )->set_context( 'carbon_fields_after_title' )->add_fields( [Field::make( 'file', Main::CFP_PLUGIN_PREFIX . 'file_item', __( 'File', 'comdev-files' ) )->set_classes( 'file_load' )->set_value_type( 'id' )->set_type( $this->get_allow_file_types() )] );
        Container::make( 'post_meta', __( 'File version', 'comdev-files' ) )->where( 'post_type', '=', Main::CFP_POST_TYPE_NAME_ITEM )->set_context( 'side' )->set_priority( 'low' )->add_fields( [Field::make( 'text', Main::CFP_PLUGIN_PREFIX . 'file_item_version', __( 'Version', 'comdev-files' ) )] );
    }

    /**
     * Get allow file types.
     *
     * @return string[]
     */
    private function get_allow_file_types() : array {
        $allow_file_type = get_option( 'comdev_files_setting_file_ext' );
        if ( empty( $allow_file_type ) ) {
            return $this->get_mime_types( ['jpg', 'zip', 'pdf'] );
        }
        $allow_file_type = explode( ',', $allow_file_type );
        $mime_types = $this->get_mime_types( $allow_file_type );
        return $mime_types;
    }

    /**
     * Get file mime types.
     *
     * @param array $file_types File types.
     *
     * @return array
     */
    private function get_mime_types( array $file_types ) : array {
        if ( empty( $file_types ) ) {
            return [];
        }
        $wp_mime_types = wp_get_mime_types();
        $mim_types = [];
        foreach ( $file_types as $type ) {
            if ( array_key_exists( $type, $wp_mime_types ) ) {
                $mim_types[] = $wp_mime_types[$type];
            }
            if ( 'jpg' === $type || 'jpeg' === $type || 'jpe' === $type ) {
                $mim_types[] = 'image/jpeg';
            }
        }
        return $mim_types;
    }

    /**
     * Add carbon fields to custom post type download list
     *
     * @return void
     */
    public function add_fields_to_download_lists() : void {
        global $comdev_files_cd_fs;
        Container::make( 'post_meta', __( 'Comdev Download List', 'comdev-files' ) )->where( 'post_type', '=', Main::CFP_POST_TYPE_NAME_ITEM_LIST )->add_fields( [Field::make( 'association', Main::CFP_PLUGIN_PREFIX . 'files_list', __( 'Include Files', 'comdev-files' ) )->set_types( [[
            'type'      => 'post',
            'post_type' => Main::CFP_POST_TYPE_NAME_ITEM,
        ]] )->set_help_text( __( 'Include single or multiple files to be added to the download list.', 'comdev-files' ) ), Field::make( 'select', Main::CFP_PLUGIN_PREFIX . 'template_name', __( 'List Template', 'comdev-files' ) )->add_options( DBHelpers::get_templates_to_select() )->set_help_text( 'Choose the preferred template for download section. Template previews can be seen <a href="' . esc_url( admin_url( '/admin.php?page=comdev-files-templates' ) ) . '">here</a>' )] );
        Container::make( 'post_meta', __( 'List Shortcode', 'comdev-files' ) )->where( 'post_type', '=', Main::CFP_POST_TYPE_NAME_ITEM_LIST )->set_priority( 'high' )->add_fields( [Field::make( 'text', Main::CFP_PLUGIN_PREFIX . 'short_code', __( 'Shortcode', 'comdev-files' ) )->set_attribute( 'placeholder', __( 'Add files and save the post to generate short code', 'comdev-files' ) )->set_classes( 'short-code-text' )->set_width( 80 )->set_help_text( ' insert into your posts, pages, widgets, or theme files to display download.' ), Field::make( 'html', Main::CFP_PLUGIN_PREFIX . 'copy_shortcode' )->set_html( '<a href="#" class="uk-button uk-button-primary uk-margin-top copy_button"> <span uk-icon="icon: copy; ratio 0.5"></span> ' . __( 'Copy', 'comdev-files' ) . '</a>' )->set_width( 20 )] );
    }

    /**
     * List options in product.
     *
     * @return void
     */
    public function add_fields_to_product() : void {
        global $comdev_files_cd_fs;
        $lists_option = [];
        $help_list_text = __( 'Please upgrade to the <a href="admin.php?page=comdev-files-pricing">PRO</a> version to attach download lists, sell them as part of a product, and set their expiry dates.', 'comdev-files' );
        $help_date_text = __( 'Please upgrade to the <a href="admin.php?page=comdev-files-pricing">PRO</a> version to attach download lists, sell them as part of a product, and set their expiry dates.', 'comdev-files' );
        Container::make( 'post_meta', __( 'Comdev Download List', 'comdev-files' ) )->where( 'post_type', '=', 'product' )->set_priority( 'high' )->add_fields( [Field::make( 'select', Main::CFP_PLUGIN_PREFIX . 'download_listing_product', __( 'Select the Download List to Sell within the Product', 'comdev-files' ) )->set_options( $lists_option )->set_help_text( $help_list_text ), Field::make( 'date', Main::CFP_PLUGIN_PREFIX . 'expiry_download', __( 'Download Expiry Date', 'comdev-files' ) )->set_attribute( 'placeholder', __( 'Set Date', 'comdev-files' ) )->set_storage_format( 'd-m-Y' )->set_input_format( 'd-m-Y', 'd-m-Y' )->set_help_text( $help_date_text )] );
    }

}
