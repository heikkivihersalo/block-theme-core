<?php
/**
 * Already Exists Exception
 *
 * @link       https://www.kotisivu.dev
 * @since      2.0.0
 *
 * @package    HeikkiVihersalo\BlockThemeCore\Theme\Api\Responses\AlreadyExistsException
 */

namespace HeikkiVihersalo\BlockThemeCore\Theme\Api\Responses;

defined( 'ABSPATH' ) || die();

use HeikkiVihersalo\BlockThemeCore\Theme\Api\Interfaces\ExceptionInterface;
use HeikkiVihersalo\BlockThemeCore\Theme\Api\Enums\HTTP_Error_Already_Exists;

/**
 * Already Exists Exception
 *
 * @since      2.0.0
 * @package    HeikkiVihersalo\BlockThemeCore\Theme\Api\Responses\AlreadyExistsException
 * @author     Heikki Vihersalo <heikki@vihersalo.fi>
 */
class AlreadyExistsException extends \Exception implements ExceptionInterface {
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
	public function __construct( $message = null, HTTP_Error_Already_Exists $error = HTTP_Error_Already_Exists::GENERIC_400 ) {
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
