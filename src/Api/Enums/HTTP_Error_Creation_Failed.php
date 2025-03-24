<?php
/**
 * HTTP Error Creation Failed
 *
 * @link       https://www.kotisivu.dev
 * @since      1.0.0
 *
 * @package    Vihersalo\Core\Theme\Api\Enums\HTTP_Error_Creation_Failed
 */

namespace Vihersalo\Core\Theme\Api\Enums;

defined( 'ABSPATH' ) || die();

use Vihersalo\Core\Theme\Api\Interfaces\HTTP_Response_Interface;

/**
 * HTTP Error Creation Failed
 *
 * @since      1.0.0
 * @package    Vihersalo\Core\Theme\Api\Enums\HTTP_Error_Creation_Failed
 * @author     Heikki Vihersalo <heikki@vihersalo.fi>
 */
enum HTTP_Error_Creation_Failed implements HTTP_Response_Interface {
	case GENERIC;

	public function values(): array {
		return match ( $this ) {
			self::GENERIC => [
				'message'     => __( 'Failed to create resource.', 'Vihersalo-block-theme-core' ),
				'type'        => 'creation_failed',
				'code'        => 3000,
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
