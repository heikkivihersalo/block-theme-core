<?php
/**
 * Class for handling excerpt customizations
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
 * Class for handling excerpt customizations
 *
 * @since      2.0.0
 * @package    HeikkiVihersalo\BlockThemeCore\Theme
 * @author     Heikki Vihersalo <heikki@vihersalo.fi>
 */
class Excerpt implements RegisterHooksInterface {
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
	 * Override default excerpt length
	 *
	 * @return int
	 */
	public function custom_excerpt_length(): int {
		return 20;
	}

	/**
	 * Override default excerpt more
	 *
	 * @return string
	 */
	public function custom_excerpt_more(): string {
		return '&hellip;';
	}

	/**
	 * @inheritDoc
	 */
	public function register_hooks() {
		$this->loader->add_filter( 'excerpt_length', $this, 'custom_excerpt_length', 999 );
		$this->loader->add_filter( 'excerpt_more', $this, 'custom_excerpt_more' );
	}
}
