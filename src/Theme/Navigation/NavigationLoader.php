<?php
/**
 *
 * @link       https://www.kotisivu.dev
 * @since      2.0.0
 *
 * @package    HeikkiVihersalo\BlockThemeCore\Theme\Navigation
 */

namespace HeikkiVihersalo\BlockThemeCore\Theme\Navigation;

defined( 'ABSPATH' ) || die();

/**
 *
 * @since      2.0.0
 * @package    HeikkiVihersalo\BlockThemeCore\Theme\Navigation
 * @author     Heikki Vihersalo <heikki@vihersalo.fi>
 */
class NavigationLoader {
	/**
	 * Navigation menus
	 *
	 * @var array
	 */
	private array $menus;

	/**
	 * Constructor
	 *
	 * @param array $menus Navigation menus
	 */
	public function __construct( array $menus ) {
		$this->menus = $menus;
	}

	/**
	 * Load navigation menus
	 *
	 * @return void
	 */
	public function load(): void {
		$menu_array = array();

		foreach ( $this->menus as $menu ) :
			$menu_array[] = array(
				$menu->get_slug() => $menu->get_name(),
			);
		endforeach;

		register_nav_menus( $menu_array );
	}
}
