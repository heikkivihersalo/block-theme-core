<?php
/**
 * Class for setting the API routes for the theme.
 *
 * @link       https://www.kotisivu.dev
 * @since      1.0.0
 *
 * @package    Vihersalo\Core\Theme\Api\Routes
 */

namespace Vihersalo\Core\Theme\Api;

defined( 'ABSPATH' ) || die();

use Vihersalo\Core\Theme\Api\Routes\OptionsRoute;
use Vihersalo\Core\Theme\Api\Routes\ProductsRoute;

/**
 * Class for setting the API routes for the theme.
 *
 * @since      1.0.0
 * @package    Vihersalo\Core\Theme\Api\Routes
 * @author     Heikki Vihersalo <heikki@vihersalo.fi>
 */
class Routes {
	/**
	 * Constructor
	 *
	 * @since    1.0.0
	 * @access   public
	 */
	public function __construct() {
	}

	/**
	 * Initialize class
	 *
	 * @return void
	 */
	public function register() {
		$options = new OptionsRoute( 'options' );
		$options->register_crud_endpoints();
		$options->register_custom_endpoints();

		$products = new ProductsRoute( 'products' );
		$products->register_custom_endpoints();
	}
}
