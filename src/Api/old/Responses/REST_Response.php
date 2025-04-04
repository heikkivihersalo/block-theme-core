<?php
/**
 * REST_Response class
 *
 * @link       https://www.kotisivu.dev
 * @since      1.0.0
 *
 * @package    Vihersalo\Core\Theme\Api\Responses\REST_Response
 */

namespace Vihersalo\Core\Theme\Api\Responses;

defined( 'ABSPATH' ) || die();

/**
 * REST_Response class
 *
 * @since      1.0.0
 * @package    Vihersalo\Core\Theme\Api\Responses\REST_Response
 * @author     Heikki Vihersalo <heikki@vihersalo.fi>
 */
class REST_Response extends WP_HTTP_Response {
	/**
	 * Response type
	 * @var string
	 */
	protected $type;

	public function __construct( $data, $status = 200, $headers = [] ) {
		parent::__construct( $data, $status, $headers );
		$this->type = $this->get_type();
	}

	public function get_type() {
	}
}
