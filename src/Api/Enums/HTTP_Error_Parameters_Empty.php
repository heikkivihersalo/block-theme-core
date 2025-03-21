<?php
/**
 * HTTP Error Parameters Empty
 *
 * @link       https://www.kotisivu.dev
 * @since      2.0.0
 *
 * @package    HeikkiVihersalo\BlockThemeCore\Theme\Api\Enums\HTTP_Error_Parameters_Empty
 */

namespace HeikkiVihersalo\BlockThemeCore\Theme\Api\Enums;

defined( 'ABSPATH' ) || die();

use HeikkiVihersalo\BlockThemeCore\Theme\Api\Interfaces\HTTP_Response_Interface;

/**
 * HTTP Error Parameters Empty
 *
 * @since      2.0.0
 * @package    HeikkiVihersalo\BlockThemeCore\Theme\Api\Enums\HTTP_Error_Parameters_Empty
 * @author     Heikki Vihersalo <heikki@vihersalo.fi>
 */
enum HTTP_Error_Parameters_Empty implements HTTP_Response_Interface {
	case GENERIC;

	public function values(): array {
		return match ( $this ) {
			self::GENERIC => array(
				'message'     => __( 'Request has no parameters.', 'heikkivihersalo-block-theme-core' ),
				'type'        => 'parameters_empty',
				'code'        => 1002,
				'http_status' => 400,
			)
		};
	}

	public function get_type(): string {
		return $this->values()['type'];
	}

	public function get_message(): string {
		return $this->values()['message'];
	}

	public function get_http_status(): int {
		return $this->values()['http_status'];
	}

	public function get_code(): int {
		return $this->values()['code'];
	}
}
