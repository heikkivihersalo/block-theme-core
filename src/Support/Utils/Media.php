<?php
/**
 * Utility functions for media handling
 *
 * @link       https://www.kotisivu.dev
 * @since      2.0.0
 *
 * @package    Vihersalo\BlockThemeCore\Support\Utils
 */

namespace Vihersalo\BlockThemeCore\Support\Utils;

defined( 'ABSPATH' ) || die();

/**
 * Utility functions for media handling
 *
 * @since      2.0.0
 * @package    Vihersalo\BlockThemeCore\Support\Utils
 * @author     Heikki Vihersalo <heikki@vihersalo.fi>
 */
final class Media {
	/**
	 * This utility class should never be instantiated.
	 */
	private function __construct() {
	}

	/**
	 * Enqueue media support
	 * @return void
	 */
	public static function add_wp_media_support(): void {
		wp_enqueue_media();
	}

	/**
	 * Add image support for SVG's
	 *
	 * @param array $mimes Mime types
	 * @return array
	 */
	public static function allow_svg_uploads( array $mimes ): array {
		$mimes['svg'] = 'image/svg+xml';
		return $mimes;
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
