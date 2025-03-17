<?php
/**
 * Utility functions for helper functions
 *
 * @link       https://www.kotisivu.dev
 * @since      2.0.0
 *
 * @package    HeikkiVihersalo\BlockThemeCore\Theme\Common\Utils
 */

namespace HeikkiVihersalo\BlockThemeCore\Theme\Common\Utils;

defined( 'ABSPATH' ) || die();

/**
 * Utility functions for helper functions
 *
 * @since      2.0.0
 * @package    HeikkiVihersalo\BlockThemeCore\Theme\Common\Utils
 * @author     Heikki Vihersalo <heikki@vihersalo.fi>
 */
final class Helpers {
	/**
	 * This utility class should never be instantiated.
	 */
	private function __construct() {
	}

	/**
	 * Return true
	 *
	 * @since 2.0.0
	 * @return bool
	 */
	public static function return_true(): bool {
		return true;
	}

	/**
	 * Return false
	 *
	 * @since 2.0.0
	 * @return bool
	 */
	public static function return_false(): bool {
		return false;
	}

	/**
	 * Load a configuration file
	 *
	 * @since 2.0.0
	 * @param string $file The file to load
	 * @return array
	 */
	public static function load_config( string $file ): array {
		$config = require_once $file;

		if ( ! is_array( $config ) ) {
			return array();
		}

		return $config;
	}

	/**
	 * Check if the current page is the plugin's editor page
	 *
	 * @since    2.0.0
	 * @param string $hook The current admin page
	 * @return bool
	 */
	public static function is_editor_page( string $hook ): bool {
		return str_contains( $hook, 'post-new.php' ) || str_contains( $hook, 'post.php' );
	}

	/**
	 * Check if the current page is the plugin's editor page
	 *
	 * @since    2.0.0
	 * @param string $hook The current admin page
	 * @return bool
	 */
	public static function is_terms_page( string $hook ): bool {
		return str_contains( $hook, 'edit-tags.php' ) || str_contains( $hook, 'term.php' );
	}

	/**
	 * Get featured image metadata
	 * @param mixed  $post_id Post ID
	 * @param string $size Default: medium
	 * @return array
	 */
	public static function get_featured_image_meta( mixed $post_id, string $size = 'medium' ) {
		$id   = get_post_thumbnail_id( $post_id );
		$meta = wp_get_attachment_image_src( $id, $size );

		return array(
			'id'     => $id,
			'url'    => isset( $meta[0] ) ? $meta[0] : '',
			'width'  => isset( $meta[1] ) ? $meta[1] : '',
			'height' => isset( $meta[2] ) ? $meta[2] : '',
			'alt'    => get_post_meta( $id, '_wp_attachment_image_alt', true ),
			'title'  => get_the_title( $id ),
		);
	}
}
