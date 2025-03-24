<?php
/**
 * HTTP Error Pagination Out Of Range
 *
 * @link       https://www.kotisivu.dev
 * @since      1.0.0
 *
 * @package    Vihersalo\Core\Theme\Api\Enums\HTTP_Error_Pagination_Out_Of_Range
 */

namespace Vihersalo\Core\Theme\Api\Enums;

defined( 'ABSPATH' ) || die();

use Vihersalo\Core\Theme\Api\Interfaces\HTTP_Response_Interface;

/**
 * HTTP Error Pagination Out Of Range
 *
 * @since      1.0.0
 * @package    Vihersalo\Core\Theme\Api\Enums\HTTP_Error_Pagination_Out_Of_Range
 * @author     Heikki Vihersalo <heikki@vihersalo.fi>
 */
enum HTTP_Error_Pagination_Out_Of_Range implements HTTP_Response_Interface {
	case GENERIC;

	public function values(): array {
		return match ( $this ) {
			self::GENERIC => [
				'message'     => __( 'Pagination parameters are out of range.', 'Vihersalo-block-theme-core' ),
				'type'        => 'pagination_out_of_range',
				'code'        => 1004,
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
