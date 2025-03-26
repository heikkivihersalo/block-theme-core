<?php
/**
 * Pagination Out Of Range Exception
 *
 * @link       https://www.kotisivu.dev
 * @since      1.0.0
 *
 * @package    Vihersalo\Core\Theme\Api\Responses\PaginationOutOfRangeException
 */

namespace Vihersalo\Core\Theme\Api\Responses;

defined( 'ABSPATH' ) || die();

use Vihersalo\Core\Theme\Api\Interfaces\ExceptionInterface;
use Vihersalo\Core\Theme\Api\Enums\HTTP_Error_Pagination_Out_Of_Range;

/**
 * Pagination Out Of Range Exception
 *
 * @since      1.0.0
 * @package    Vihersalo\Core\Theme\Api\Responses\PaginationOutOfRangeException
 * @author     Heikki Vihersalo <heikki@vihersalo.fi>
 */
class PaginationOutOfRangeException extends \Exception implements ExceptionInterface {
	/**
	 * @var string|null
	 */
	protected $message;

	/**
	 * @var HTTP_Error_Pagination_Invalid_Parameters
	 */
	protected $error;

	/**
	 * @inheritDoc
	 */
	public function __construct( $message = null, HTTP_Error_Pagination_Out_Of_Range $error = HTTP_Error_Pagination_Out_Of_Range::GENERIC ) {
		parent::__construct(
			$message ? $message : $error->get_message(),
			$error->get_code()
		);

		$this->error = $error;
	}

	/**
	 * @inheritDoc
	 */
	public function get_type(): string {
		return $this->error->get_type();
	}

	/**
	 * @inheritDoc
	 */
	public function get_http_status(): int {
		return $this->error->get_http_status();
	}
}
