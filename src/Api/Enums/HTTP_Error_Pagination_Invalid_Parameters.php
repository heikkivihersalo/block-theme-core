<?php
/**
 * HTTP Error Pagination Invalid Parameters
 *
 * @link       https://www.kotisivu.dev
 * @since      2.0.0
 *
 * @package    HeikkiVihersalo\BlockThemeCore\Theme\Api\Enums\HTTP_Error_Pagination_Invalid_Parameters
 */

namespace HeikkiVihersalo\BlockThemeCore\Theme\Api\Enums;

defined( 'ABSPATH' ) || die();

use HeikkiVihersalo\BlockThemeCore\Theme\Api\Interfaces\HTTP_Response_Interface;

/**
 * HTTP Error Pagination Invalid Parameters
 *
 * @since      2.0.0
 * @package    HeikkiVihersalo\BlockThemeCore\Theme\Api\Enums\HTTP_Error_Pagination_Invalid_Parameters
 * @author     Heikki Vihersalo <heikki@vihersalo.fi>
 */
enum HTTP_Error_Pagination_Invalid_Parameters implements HTTP_Response_Interface {
	case GENERIC;

	public function values(): array {
		return match ( $this ) {
			self::GENERIC => array(
				'message'     => __( 'Pagination parameters are invalid.', 'heikkivihersalo-block-theme-core' ),
				'type'        => 'pagination_invalid_parameters',
				'code'        => 1003,
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
