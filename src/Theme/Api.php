<?php
/**
 * The API functionality of the theme.
 *
 * @link       https://www.kotisivu.dev
 * @since      2.0.0
 *
 * @package    HeikkiVihersalo\BlockThemeCore\Theme
 */

namespace HeikkiVihersalo\BlockThemeCore\Theme;

defined( 'ABSPATH' ) || die();

use HeikkiVihersalo\BlockThemeCore\Theme\Api\Routes;
use HeikkiVihersalo\BlockThemeCore\Theme\Api\RestFields;
use HeikkiVihersalo\BlockThemeCore\Theme\Common\Loader;
use HeikkiVihersalo\BlockThemeCore\Theme\Common\Traits\ThemeDefaults;
use HeikkiVihersalo\BlockThemeCore\Theme\Common\Interfaces\RegisterHooksInterface;

/**
 * The API functionality of the theme.
 *
 * @since      2.0.0
 * @package    HeikkiVihersalo\BlockThemeCore\Theme
 * @author     Heikki Vihersalo <heikki@vihersalo.fi>
 */
class Api implements RegisterHooksInterface {
	use ThemeDefaults;

	/**
	 * Constructor
	 *
	 * @since    2.0.0
	 * @access   public
	 */
	public function __construct( Loader $loader, string $theme_name, string $version, string $api_version ) {
		$this->loader      = $loader;
		$this->theme_name  = $theme_name;
		$this->version     = $version;
		$this->api_version = $api_version;
	}

	/**
	 * Register the API routes for the theme.
	 *
	 * @since    2.0.0
	 * @access   public
	 * @return   void
	 */
	private function set_api_routes() {
		$api = new Routes( $this->theme_name, $this->version, $this->api_version );
		$this->loader->add_action( 'rest_api_init', $api, 'register' );
	}

	/**
	 * Register the custom REST fields for the theme.
	 *
	 * @since    2.0.0
	 * @access   private
	 * @return   void
	 */
	private function set_api_rest_fields() {
		$fields = new RestFields( $this->theme_name, $this->version );
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
