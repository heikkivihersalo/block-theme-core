<?php
/**
 * Class for handling customizations for file uploads
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
use HeikkiVihersalo\BlockThemeCore\Theme\Common\Utils\Media as MediaUtils;
use HeikkiVihersalo\BlockThemeCore\Theme\Common\Interfaces\RegisterHooksInterface;

/**
 * Class for handling customizations for file uploads
 *
 * @since      2.0.0
 * @package    HeikkiVihersalo\BlockThemeCore\Theme
 * @author     Heikki Vihersalo <heikki@vihersalo.fi>
 */
class Uploads implements RegisterHooksInterface {
	use ThemeDefaults;

	/**
	 * Constructor
	 *
	 * @since    2.0.0
	 * @access   public
	 */
	public function __construct( Loader $loader ) {
		$this->loader = $loader;
	}

	/**
	 * Set file uploads
	 *
	 * @since    2.0.0
	 * @access   public
	 * @return   void
	 */
	private function set_file_uploads() {
		$this->loader->add_filter( 'upload_mimes', MediaUtils::class, 'allow_svg_uploads' );
	}

	/**
	 * @inheritDoc
	 */
	public function register_hooks() {
		$this->set_file_uploads();
	}
}
