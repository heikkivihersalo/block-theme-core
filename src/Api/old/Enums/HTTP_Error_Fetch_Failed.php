<?php
/**
 * HTTP Error Fetch Failed
 *
 * @link       https://www.kotisivu.dev
 * @since      1.0.0
 *
 * @package    Vihersalo\Core\Theme\Api\Enums\HTTP_Error_Fetch_Failed
 */

namespace Vihersalo\Core\Theme\Api\Enums;

defined( 'ABSPATH' ) || die();

use Vihersalo\Core\Theme\Api\Interfaces\HTTP_Response_Interface;

/**
 * HTTP Error Fetch Failed
 *
 * @since      1.0.0
 * @package    Vihersalo\Core\Theme\Api\Enums\HTTP_Error_Fetch_Failed
 * @author     Heikki Vihersalo <heikki@vihersalo.fi>
 */
enum HTTP_Error_Fetch_Failed implements HTTP_Response_Interface {
	case GENERIC;

	public function values(): array {
		return match ( $this ) {
			self::GENERIC => [
				'message'     => __( 'Failed to fetch resource.', 'Vihersalo-block-theme-core' ),
				'type'        => 'fetch_failed',
				'code'        => 2003,
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
