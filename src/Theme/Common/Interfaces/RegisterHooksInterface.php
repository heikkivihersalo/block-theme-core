<?php
/**
 * Register interface.
 *
 * @link       https://www.kotisivu.dev
 * @since      2.0.0
 *
 * @package    HeikkiVihersalo\BlockThemeCore\Common\Interfaces
 */

namespace HeikkiVihersalo\BlockThemeCore\Theme\Common\Interfaces;

/**
 * Register interface.
 *
 * @since      2.0.0
 * @package    HeikkiVihersalo\BlockThemeCore\Common\Interfaces
 * @author     Heikki Vihersalo <heikki@vihersalo.fi>
 */
interface RegisterHooksInterface {
	/**
	 * Registers hooks for the loader
	 *
	 * @since 2.0.0
	 * @access public
	 * @return void
	 */
	public function register_hooks();
}
