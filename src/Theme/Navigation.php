<?php
/**
 * Navigation functionality of the theme.
 *
 * @link       https://www.kotisivu.dev
 * @since      2.0.0
 *
 * @package    HeikkiVihersalo\BlockThemeCore\Theme
 */

namespace HeikkiVihersalo\BlockThemeCore\Theme;

defined( 'ABSPATH' ) || die();

use HeikkiVihersalo\BlockThemeCore\Theme\Common\Loader;
use HeikkiVihersalo\BlockThemeCore\Theme\Common\Traits\ThemeDefaults;
use HeikkiVihersalo\BlockThemeCore\Theme\Common\Interfaces\RegisterHooksInterface;

/**
 * Navigation functionality of the theme.
 *
 * @since      2.0.0
 * @package    HeikkiVihersalo\BlockThemeCore\Theme
 * @author     Heikki Vihersalo <heikki@vihersalo.fi>
 */
class Navigation implements RegisterHooksInterface {
	use ThemeDefaults;

	/**
	 * Default image sizes
	 *
	 * @since 2.0.0
	 * @access private
	 * @var array $custom_image_sizes Array of custom image sizes
	 */
	private array $menu_locations;

	/**
	 * Constructor
	 *
	 * @since    2.0.0
	 * @access   public
	 */
	public function __construct( Loader $loader, array $menu_locations ) {
		$this->loader         = $loader;
		$this->menu_locations = $menu_locations;
	}

	/**
	 * Load navigation menus
	 *
	 * @return void
	 */
	public function register_navigation_menus(): void {
		$menu_array = array();

		foreach ( $this->menu_locations as $menu ) :
			$menu_array[] = $menu->get_navigation_menu();
		endforeach;

		register_nav_menus( $menu_array );
	}

	/**
	 * @inheritDoc
	 */
	public function register_hooks() {
		$this->loader->add_action( 'init', $this, 'register_navigation_menus' );
	}
}
