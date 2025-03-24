<?php
/**
 * HTTP Response Interface
 *
 * @link       https://www.kotisivu.dev
 * @since      1.0.0
 *
 * @package    Vihersalo\Core\Theme\Api\Interfaces\HTTP_Response_Interface
 */

namespace Vihersalo\Core\Theme\Api\Interfaces;

defined( 'ABSPATH' ) || die();

/**
 * HTTP Response Interface
 *
 * @since      1.0.0
 * @package    Vihersalo\Core\Theme\Api\Interfaces\HTTP_Response_Interface
 * @author     Heikki Vihersalo <heikki@vihersalo.fi>
 */
interface HTTP_Response_Interface {
	public function values();
	public function get_type();
	public function get_message();
	public function get_http_status();
}
