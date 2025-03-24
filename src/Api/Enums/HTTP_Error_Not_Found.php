<?php
/**
 * HTTP Error Not Found
 *
 * @link       https://www.kotisivu.dev
 * @since      1.0.0
 *
 * @package    Vihersalo\Core\Theme\Api\Enums\HTTP_Error_Not_Found
 */

namespace Vihersalo\Core\Theme\Api\Enums;

defined( 'ABSPATH' ) || die();

use Vihersalo\Core\Theme\Api\Interfaces\HTTP_Response_Interface;

/**
 * HTTP Error Not Found
 *
 * @since      1.0.0
 * @package    Vihersalo\Core\Theme\Api\Enums\HTTP_Error_Not_Found
 * @author     Heikki Vihersalo <heikki@vihersalo.fi>
 */
enum HTTP_Error_Not_Found implements HTTP_Response_Interface {
	case GENERIC;

	public function values(): array {
		return match ( $this ) {
			self::GENERIC => [
				'message'     => __( 'Resource not found.', 'Vihersalo-block-theme-core' ),
				'type'        => 'not_found',
				'code'        => 2000,
				'http_status' => 404,
			]
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
