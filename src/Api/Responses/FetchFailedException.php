<?php
/**
 * Fetch Failed Exception
 *
 * @link       https://www.kotisivu.dev
 * @since      2.0.0
 *
 * @package    HeikkiVihersalo\BlockThemeCore\Theme\Api\Responses\FetchFailedException
 */

namespace HeikkiVihersalo\BlockThemeCore\Theme\Api\Responses;

defined( 'ABSPATH' ) || die();

use HeikkiVihersalo\BlockThemeCore\Theme\Api\Interfaces\ExceptionInterface;
use HeikkiVihersalo\BlockThemeCore\Theme\Api\Enums\HTTP_Error_Fetch_Failed;

/**
 * Fetch Failed Exception
 *
 * @since      2.0.0
 * @package    HeikkiVihersalo\BlockThemeCore\Theme\Api\Responses\FetchFailedException
 * @author     Heikki Vihersalo <heikki@vihersalo.fi>
 */
class FetchFailedException extends \Exception implements ExceptionInterface {
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
	public function __construct( $message = null, HTTP_Error_Fetch_Failed $error = HTTP_Error_Fetch_Failed::GENERIC ) {
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
