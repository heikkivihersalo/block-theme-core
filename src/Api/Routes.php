<?php
/**
 * Class for setting the API routes for the theme.
 *
 * @link       https://www.kotisivu.dev
 * @since      2.0.0
 *
 * @package    HeikkiVihersalo\BlockThemeCore\Theme\Api\Routes
 */

namespace HeikkiVihersalo\BlockThemeCore\Theme\Api;

defined( 'ABSPATH' ) || die();

use HeikkiVihersalo\BlockThemeCore\Theme\Api\Routes\OptionsRoute;
use HeikkiVihersalo\BlockThemeCore\Theme\Api\Routes\ProductsRoute;

/**
 * Class for setting the API routes for the theme.
 *
 * @since      2.0.0
 * @package    HeikkiVihersalo\BlockThemeCore\Theme\Api\Routes
 * @author     Heikki Vihersalo <heikki@vihersalo.fi>
 */
class Routes {
	/**
	 * Constructor
	 *
	 * @since    2.0.0
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
