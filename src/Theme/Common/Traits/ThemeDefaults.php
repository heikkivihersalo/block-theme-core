<?php
/**
 * General theme defaults and properties
 *
 * @link       https://www.kotisivu.dev
 * @since      2.0.0
 *
 * @package    HeikkiVihersalo\BlockThemeCore\Theme\Common
 */

namespace HeikkiVihersalo\BlockThemeCore\Theme\Common\Traits;

use HeikkiVihersalo\BlockThemeCore\Theme\Common\Loader;

/**
 * General theme defaults and properties
 *
 * @since      2.0.0
 * @package    HeikkiVihersalo\BlockThemeCore\Theme\Common
 * @author     Heikki Vihersalo <heikki@vihersalo.fi>
 */
trait ThemeDefaults {
	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the theme.
	 *
	 * @since    2.0.0
	 * @access   protected
	 * @var      Loader    $loader    Maintains and registers all hooks for the theme.
	 */
	protected Loader $loader;

	/**
	 * The reference to the class that orchestrates the hooks with the theme.
	 *
	 * @since     2.0.0
	 * @return    Loader    Orchestrates the hooks of the theme.
	 */
	public function get_loader(): Loader {
		return $this->loader;
	}
}
