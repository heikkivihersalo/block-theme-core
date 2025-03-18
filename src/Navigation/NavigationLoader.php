<?php
/**
 * Navigation functionality of the theme.
 *
 * @link       https://www.kotisivu.dev
 * @since      2.0.0
 *
 * @package    HeikkiVihersalo\BlockThemeCore\Theme
 */

namespace HeikkiVihersalo\BlockThemeCore\Navigation;

use HeikkiVihersalo\BlockThemeCore\Loader;
use HeikkiVihersalo\BlockThemeCore\Application;

defined( 'ABSPATH' ) || die();

/**
 * Navigation functionality of the theme.
 *
 * @since      2.0.0
 * @package    HeikkiVihersalo\BlockThemeCore\Theme
 * @author     Heikki Vihersalo <heikki@vihersalo.fi>
 */
class NavigationLoader {
	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the theme.
	 *
	 * @since 2.0.0
	 * @access protected
	 * @var Loader $loader Maintains and registers all hooks for the theme.
	 */
	protected Loader $loader;

	/**
	 * Default image sizes
	 *
	 * @since 2.0.0
	 * @access private
	 * @var array $custom_image_sizes Array of custom image sizes
	 */
	private array $locations;

	/**
	 * Constructor
	 *
	 * @since    2.0.0
	 * @access   public
	 */
	public function __construct( Loader $loader, array $locations ) {
		$this->loader = $loader;
        $this->locations = $locations;
	}

	/**
	 * Load navigation menus
	 *
	 * @return void
	 */
	public function register_navigation_menus(): void {
		foreach ( $this->locations as $menu ) :
			register_nav_menu( $menu->get_slug(), $menu->get_name() );
		endforeach;
	}

	/**
	 * @inheritDoc
	 */
	public function register_hooks() {
		$this->loader->add_action( 'init', $this, 'register_navigation_menus' );
	}
}
