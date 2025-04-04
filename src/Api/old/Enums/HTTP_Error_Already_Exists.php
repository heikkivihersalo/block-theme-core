<?php
/**
 * HTTP Error Already Exists
 *
 * @link       https://www.kotisivu.dev
 * @since      1.0.0
 *
 * @package    Vihersalo\Core\Theme\Api\Enums\HTTP_Error_Already_Exists
 */

namespace Vihersalo\Core\Theme\Api\Enums;

defined( 'ABSPATH' ) || die();

use Vihersalo\Core\Theme\Api\Interfaces\HTTP_Response_Interface;

/**
 * HTTP Error Already Exists
 *
 * @since      1.0.0
 * @package    Vihersalo\Core\Theme\Api\Enums\HTTP_Error_Already_Exists
 * @author     Heikki Vihersalo <heikki@vihersalo.fi>
 */
enum HTTP_Error_Already_Exists implements HTTP_Response_Interface {
	case GENERIC_200;
	case GENERIC_400;

	public function values(): array {
		return match ( $this ) {
			self::GENERIC_200 => [
				'message'     => __( 'Resource already exists.', 'Vihersalo-block-theme-core' ),
				'type'        => 'already_exists',
				'code'        => 2001,
				'http_status' => 200,
			],
			self::GENERIC_400 => [
				'message'     => __( 'Resource already exists.', 'Vihersalo-block-theme-core' ),
				'type'        => 'already_exists',
				'code'        => 2002,
				'http_status' => 400,
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
