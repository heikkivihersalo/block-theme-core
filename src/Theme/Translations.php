<?php
/**
 * Translations
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

/**
 * Class for handling translations
 *
 * @since      2.0.0
 * @package    HeikkiVihersalo\BlockThemeCore\Theme
 * @author     Heikki Vihersalo <heikki@vihersalo.fi>
 */
class Translations {
	use ThemeDefaults;

	/**
	 * Load the text domain for the theme
	 *
	 * @since    2.0.0
	 * @access   public
	 */
	public function load_textdomain() {
		load_theme_textdomain( 'heikkivihersalo-block-theme-core', SITE_PATH . '/languages' );
	}
}
