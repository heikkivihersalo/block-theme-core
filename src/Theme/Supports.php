<?php
/**
 * Class for handling customizations for the theme supports
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
 * Class for handling customizations for the theme supports
 *
 * @since      2.0.0
 * @package    HeikkiVihersalo\BlockThemeCore\Theme
 * @author     Heikki Vihersalo <heikki@vihersalo.fi>
 */
class Supports {
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
	 * Set theme supports
	 *
	 * @since    2.0.0
	 * @access   public
	 * @return   void
	 */
	public function add_theme_supports() {
		add_theme_support( 'wp-block-styles' );
		add_theme_support( 'align-wide' );
		add_theme_support( 'custom-logo' );
		add_theme_support( 'menus' );
		add_theme_support( 'editor-styles' );
	}

	/**
	 * Remove theme supports
	 *
	 * @since    2.0.0
	 * @access   public
	 * @return   void
	 */
	public function remove_theme_supports() {
		remove_theme_support( 'core-block-patterns' );
	}

	/**
	 * Registers hooks for the loader
	 *
	 * @since 2.0.0
	 * @access public
	 * @return void
	 */
	public function register_hooks() {
		$this->loader->add_action( 'after_setup_theme', $this, 'add_theme_supports' );
		$this->loader->add_action( 'after_setup_theme', $this, 'remove_theme_supports' );
	}
}
