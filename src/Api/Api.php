<?php
/**
 * The API functionality of the theme.
 *
 * @link       https://www.kotisivu.dev
 * @since      1.0.0
 *
 * @package    Vihersalo\Core\Theme
 */

namespace Vihersalo\Core\Theme;

defined( 'ABSPATH' ) || die();

use Vihersalo\Core\Theme\Api\Routes;
use Vihersalo\Core\Theme\Api\RestFields;
use Vihersalo\Core\Theme\Common\Loader;
use Vihersalo\Core\Theme\Common\Traits\ThemeDefaults;
use Vihersalo\Core\Theme\Common\Interfaces\RegisterHooksInterface;

/**
 * The API functionality of the theme.
 *
 * @since      1.0.0
 * @package    Vihersalo\Core\Theme
 * @author     Heikki Vihersalo <heikki@vihersalo.fi>
 */
class Api implements RegisterHooksInterface {
	use ThemeDefaults;

	/**
	 * Constructor
	 *
	 * @since    1.0.0
	 * @access   public
	 */
	public function __construct( Loader $loader ) {
		$this->loader = $loader;
	}

	/**
	 * Register the API routes for the theme.
	 *
	 * @since    1.0.0
	 * @access   public
	 * @return   void
	 */
	private function set_api_routes() {
		$api = new Routes();
		$this->loader->add_action( 'rest_api_init', $api, 'register' );
	}

	/**
	 * Register the custom REST fields for the theme.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @return   void
	 */
	private function set_api_rest_fields() {
		$fields = new RestFields();
		$this->loader->add_action( 'rest_api_init', $fields, 'register' );
	}

	/**
	 * @inheritDoc
	 */
	public function register_hooks() {
		$this->set_api_routes();
		$this->set_api_rest_fields();
	}
}
