<?php
/**
 * Class for registering custom fields for the rest API
 *
 * @link       https://www.kotisivu.dev
 * @since      2.0.0
 *
 * @package    HeikkiVihersalo\BlockThemeCore\Theme\Api\RestFields
 */

namespace HeikkiVihersalo\BlockThemeCore\Theme\Api;

defined( 'ABSPATH' ) || die();

use HeikkiVihersalo\BlockThemeCore\Theme\Api\Traits\CustomRestField;
use HeikkiVihersalo\BlockThemeCore\Theme\Api\Traits\FormatImageMeta;

/**
 * Class for registering custom fields for the rest API
 *
 * @since      2.0.0
 * @package    HeikkiVihersalo\BlockThemeCore\Theme\Api\RestFields
 * @author     Heikki Vihersalo <heikki@vihersalo.fi>
 */
class RestFields {
	use FormatImageMeta;
	use CustomRestField;

	/**
	 * Register the custom REST fields
	 *
	 * @return void
	 */
	public function register() {
		$this->register_custom_rest_field(
			'post',
			'metadata',
			function ( $data ) {
				$meta                   = get_post_meta( $data['id'], '', '' );
				$meta['featured_image'] = $this->get_featured_image_meta( $data['id'], 'full' );
				return $meta;
			}
		);

		$this->register_custom_rest_field(
			'attachment',
			'metadata',
			function ( $data ) {
				$meta                   = get_post_meta( $data['id'], '', '' );
				$meta['featured_image'] = $this->get_featured_image_meta( $data['id'], 'medium' );
				return $meta;
			}
		);
	}
}
