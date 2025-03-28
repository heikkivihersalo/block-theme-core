<?php
/**
 * HTTP Error Not Implemented
 *
 * @link       https://www.kotisivu.dev
 * @since      1.0.0
 *
 * @package    Vihersalo\Core\Theme\Api\Enums\HTTP_Error_Not_Implemented
 */

namespace Vihersalo\Core\Theme\Api\Enums;

defined( 'ABSPATH' ) || die();

use Vihersalo\Core\Theme\Api\Interfaces\HTTP_Response_Interface;

/**
 * HTTP Error Not Implemented
 *
 * @since      1.0.0
 * @package    Vihersalo\Core\Theme\Api\Enums\HTTP_Error_Not_Implemented
 * @author     Heikki Vihersalo <heikki@vihersalo.fi>
 */
enum HTTP_Error_Not_Implemented implements HTTP_Response_Interface {
	case GENERIC; // 9000

	public function values(): array {
		return match ( $this ) {
			self::GENERIC => [
				'message'     => __( 'Not implemented.', 'Vihersalo-block-theme-core' ),
				'type'        => 'not_implemented',
				'code'        => 9000,
				'http_status' => 501,
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
