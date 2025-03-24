<?php
/**
 * HTTP Success
 *
 * @link       https://www.kotisivu.dev
 * @since      1.0.0
 *
 * @package    Vihersalo\Core\Theme\Api\Enums\HTTP_Success
 */

namespace Vihersalo\Core\Theme\Api\Enums;

defined( 'ABSPATH' ) || die();

use Vihersalo\Core\Theme\Api\Interfaces\HTTP_Response_Interface;

/**
 * HTTP Success
 *
 * @since      1.0.0
 * @package    Vihersalo\Core\Theme\Api\Enums\HTTP_Success
 * @author     Heikki Vihersalo <heikki@vihersalo.fi>
 */
enum HTTP_Success implements HTTP_Response_Interface {
	case FETCHED_SUCCESSFULLY;
	case CREATED_SUCCESSFULLY;
	case UPDATED_SUCCESSFULLY;
	case DELETED_SUCCESSFULLY;
	case CLEARED_SUCCESSFULLY;

	public function values(): array {
		return match ( $this ) {
			self::FETCHED_SUCCESSFULLY => [
				'message'     => __( 'Resource fetched successfully.', 'Vihersalo-block-theme-core' ),
				'type'        => 'fetch_success',
				'http_status' => 200,
			],
			self::CREATED_SUCCESSFULLY => [
				'message'     => __( 'Resource created successfully.', 'Vihersalo-block-theme-core' ),
				'type'        => 'create_success',
				'http_status' => 201,
			],
			self::UPDATED_SUCCESSFULLY => [
				'message'     => __( 'Resource updated successfully.', 'Vihersalo-block-theme-core' ),
				'type'        => 'update_success',
				'http_status' => 200,
			],
			self::DELETED_SUCCESSFULLY => [
				'message'     => __( 'Resource deleted successfully.', 'Vihersalo-block-theme-core' ),
				'type'        => 'delete_success',
				'http_status' => 200,
			],
			self::CLEARED_SUCCESSFULLY => [
				'message'     => __( 'Resource cleared successfully.', 'Vihersalo-block-theme-core' ),
				'type'        => 'clear_success',
				'http_status' => 200,
			],
		};
	}

	public function get_type(): string {
		return match ( $this ) {
			self::FETCHED_SUCCESSFULLY,
			self::CREATED_SUCCESSFULLY,
			self::UPDATED_SUCCESSFULLY,
			self::DELETED_SUCCESSFULLY,
			self::CLEARED_SUCCESSFULLY => $this->values()['type'],
		};
	}

	public function get_message(): string {
		return match ( $this ) {
			self::FETCHED_SUCCESSFULLY,
			self::CREATED_SUCCESSFULLY,
			self::UPDATED_SUCCESSFULLY,
			self::DELETED_SUCCESSFULLY,
			self::CLEARED_SUCCESSFULLY => $this->values()['message'],
		};
	}

	public function get_http_status(): int {
		return match ( $this ) {
			self::FETCHED_SUCCESSFULLY,
			self::CREATED_SUCCESSFULLY,
			self::UPDATED_SUCCESSFULLY,
			self::DELETED_SUCCESSFULLY,
			self::CLEARED_SUCCESSFULLY => $this->values()['http_status'],
		};
	}

	public function get_response_body( string $message = null, array $data = null, array $pagination = null ): array {
		return match ( $this ) {
			self::FETCHED_SUCCESSFULLY => [
				'status'     => 'success',
				'type'       => $this->values()['type'],
				'message'    => $message
					? $message
					: $this->values()['message'],
				'data'       => $data,
				'pagination' => $pagination ? $pagination : null,
			],
			self::CREATED_SUCCESSFULLY,
			self::UPDATED_SUCCESSFULLY,
			self::DELETED_SUCCESSFULLY,
			self::CLEARED_SUCCESSFULLY => [
				'status'  => 'success',
				'type'    => $this->values()['type'],
				'message' => $message
					? $message
					: $this->values()['message'],
				'data'    => $data,
			]
		};
	}
}
