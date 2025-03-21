<?php
/**
 *
 * @link       https://www.kotisivu.dev
 * @since      2.0.0
 *
 * @package    Vihersalo\BlockThemeCore\Support\Pages
 */

namespace Vihersalo\BlockThemeCore\Support\Collections;

defined( 'ABSPATH' ) || die();

use Vihersalo\BlockThemeCore\Support\Pages\Submenu;

/**
 *
 * @since      2.0.0
 * @package    Vihersalo\BlockThemeCore\Support\Pages
 * @author     Heikki Vihersalo <heikki@vihersalo.fi>
 */
class MenuCollection {
	/**
	 * The menus
	 *
	 * @var array $menus The menus
	 */
	private $menus = [];

	/**
	 * Constructor
	 *
	 * @since 2.0.0
	 * @access private
	 * @return void
	 */
	public function __construct() {
	}

	/**
	 * Add a menu or array of menus
	 *
	 * @param Submenu|array $submenu The submenu or array of submenus
	 * @return self
	 */
	public function add( $submenu ) {
		if ( is_array( $submenu ) ) {
			foreach ( $submenu as $menu ) {
				if ( $menu instanceof Submenu ) {
					$this->menus[] = $menu;
				}
			}

			return $this;
		}

		if ( $submenu instanceof Submenu ) {
			$this->menus[] = $submenu;
		}

		return $this;
	}

	/**
	 * Get the menus
	 *
	 * @return array The menus
	 */
	public function get(): array {
		return $this->menus;
	}
}
