<?php

/**
 * Frontend helpers class.
 *
 * @package comdev/files
 */
namespace Comdev\Files\Helpers;

use Comdev\Files\Main;
use DateTime;
use WP_Query;
/**
 * FrontEndHelpers class file.
 */
class FrontEndHelpers {
    /**
     * Get listing content.
     *
     * @param array  $listing_id  Listing template.
     * @param string $template    Template.
     * @param string $date_expiry Date expiry only pro version.
     *
     * @return string
     */
    public static function get_listing_content( array $listing_id, string $template, $date_expiry = '' ) : string {
        if ( empty( $listing_id ) ) {
            return __( 'Listing is empty', 'comdev-files' );
        }
        global $post;
        global $comdev_files_cd_fs;
        if ( $comdev_files_cd_fs->is__premium_only() && !empty( $date_expiry ) ) {
            $current_date = gmdate( 'Y-m-d' );
            $current_date = new DateTime();
            $specified_date = DateTime::createFromFormat( 'd-m-Y', $date_expiry );
            if ( $current_date < $specified_date ) {
                return sprintf( '<p class="%s">%s</p>', 'notification warning', __( 'You cannot see this listing, its validity date has expired', 'comdev-files' ) );
            }
        }
        $settings_display_version = get_option( 'comdev_files_setting_show_ver' );
        $settings_display_size = get_option( 'comdev_files_setting_show_size' );
        $user_permission = get_option( 'comdev_files_setting_user_access', 'false' );
        $listing_html = '';
        foreach ( $listing_id as $item ) {
            $file_id = (int) carbon_get_post_meta( $item['id'], Main::CFP_PLUGIN_PREFIX . 'file_item' );
            $url = ( 'product' === $post->post_type ? '#' : wp_get_attachment_url( $file_id ) );
            $file_name = basename( wp_get_attachment_url( $file_id ) );
            $class = '';
            if ( 'true' === $user_permission && is_user_logged_in() ) {
                $url = ( 'product' === $post->post_type ? '#' : wp_get_attachment_url( $file_id ) );
                $file_name = basename( wp_get_attachment_url( $file_id ) );
            } elseif ( 'true' === $user_permission && !is_user_logged_in() ) {
                $url = '#';
                $file_name = __( 'Please log in to download files.', 'comdev-files' );
                $class = 'cd-link-disabled';
            }
            $listing_html .= sprintf(
                '<tr><td><a class="%s" href="%s" target="_blank" rel="noreferrer nofolow">%s</a></td><td>%s</td><td>%s</td></tr>',
                esc_attr( $class ),
                esc_url( $url ),
                esc_html( $file_name ),
                ( !empty( $settings_display_version ) ? ( carbon_get_post_meta( $item['id'], Main::CFP_PLUGIN_PREFIX . 'file_item_version' ) ?: '-' ) : '-' ),
                ( !empty( $settings_display_size ) ? size_format( filesize( get_attached_file( $file_id ) ) ) : '-' )
            );
        }
        $content = str_replace( '{{title}}', get_the_title( $item['id'] ), $template );
        $content = str_replace( '{{listing}}', $listing_html, $content );
        return $content;
    }

    /**
     * Get total files.
     *
     * @return int
     */
    public static function get_total_files() : int {
        $arg = [
            'post_type'      => Main::CFP_POST_TYPE_NAME_ITEM,
            'posts_per_page' => 1,
            'post_status'    => 'publish',
        ];
        $files_query = new WP_Query($arg);
        return $files_query->found_posts;
    }

    /**
     * Get total packages.
     *
     * @return int
     */
    public static function get_total_packages() : int {
        $arg = [
            'post_type'      => Main::CFP_POST_TYPE_NAME_ITEM_LIST,
            'posts_per_page' => 1,
            'post_status'    => 'publish',
        ];
        $list_query = new WP_Query($arg);
        return $list_query->found_posts;
    }

}
