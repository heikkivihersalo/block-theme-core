<?php
/**
 * The core theme class.
 *
 * @link       https://www.kotisivu.dev
 * @since      2.0.0
 *
 * @package    HeikkiVihersalo\BlockThemeCore
 */

namespace HeikkiVihersalo\BlockThemeCore;

defined( 'ABSPATH' ) || die();

use HeikkiVihersalo\BlockThemeCore\Theme\Common\Loader;
use HeikkiVihersalo\BlockThemeCore\Theme\Common\Traits\CreateLoader;
use HeikkiVihersalo\BlockThemeCore\Theme\Common\Traits\ThemeDefaults;

use HeikkiVihersalo\BlockThemeCore\Theme\Admin;
use HeikkiVihersalo\BlockThemeCore\Theme\Api;
use HeikkiVihersalo\BlockThemeCore\Theme\Cleanup;
use HeikkiVihersalo\BlockThemeCore\Theme\CustomPostTypes;
use HeikkiVihersalo\BlockThemeCore\Theme\Dequeue;
use HeikkiVihersalo\BlockThemeCore\Theme\Enqueue;
use HeikkiVihersalo\BlockThemeCore\Theme\Excerpt;
use HeikkiVihersalo\BlockThemeCore\Theme\Translations;
use HeikkiVihersalo\BlockThemeCore\Theme\Image;
use HeikkiVihersalo\BlockThemeCore\Theme\Meta;
use HeikkiVihersalo\BlockThemeCore\Theme\Navigation;
use HeikkiVihersalo\BlockThemeCore\Theme\Security;
use HeikkiVihersalo\BlockThemeCore\Theme\Supports;
use HeikkiVihersalo\BlockThemeCore\Theme\Uploads;

/**
 * The core theme class.
 *
 * @since      2.0.0
 * @package    HeikkiVihersalo\BlockThemeCore
 * @author     Heikki Vihersalo <heikki@vihersalo.fi>
 */
class Theme {
	use CreateLoader;
	use ThemeDefaults;

	/**
	 * @var array
	 */
	private $enqueue;

	/**
	 * @var array
	 */
	private $excerpt;

	/**
	 * @var array
	 */
	private $image_sizes;

	/**
	 * @var array
	 */
	private $navigation;

	/**
	 * Constructor
	 *
	 * @since    2.0.0
	 * @access   public
	 */
	public function __construct( array $enqueue, array $excerpt, array $image_sizes, array $navigation ) {
		$this->enqueue     = $enqueue;
		$this->excerpt     = $excerpt;
		$this->image_sizes = $image_sizes;
		$this->navigation  = $navigation;

		$this->set_loader();
		$this->set_admin();
		$this->set_api();
		$this->set_cleanup();
		$this->set_dequeue();
		$this->set_enqueue();
		$this->set_custom_excerpt();
		$this->set_i18n();
		$this->set_custom_image();
		$this->set_meta();
		$this->set_security();
		$this->set_supports();
		$this->set_navigation();
		$this->set_uploads();
	}

	/**
	 * Register all of the hooks related to the admin area
	 *
	 * @since    2.0.0
	 * @access   private
	 * @return   void
	 */
	private function set_admin() {
		$admin = new Admin( $this->loader );
		$admin->register_hooks();
	}

	/**
	 * Register all of the hooks related to the API for the theme
	 *
	 * @since    2.0.0
	 * @access   private
	 * @return   void
	 */
	private function set_api() {
		$api = new Api( $this->loader );
		$api->register_hooks();
	}

	/**
	 * Register all of the hooks related to junk cleanup for the theme
	 *
	 * @since    2.0.0
	 * @access   private
	 * @return   void
	 */
	private function set_cleanup() {
		$cleanup = new Cleanup( $this->loader );
		$cleanup->register_hooks();
	}

	/**
	 * Register all of the hooks related to dequeeing scripts and styles for the theme
	 *
	 * @since    2.0.0
	 * @access   private
	 * @return   void
	 */
	private function set_dequeue() {
		$dequeue = new Dequeue( $this->loader );
		$dequeue->register_hooks();
	}

	/**
	 * Register all of the hooks related to the scripts and styles.
	 *
	 * @since    2.0.0
	 * @access   private
	 */
	private function set_enqueue() {
		$enqueue = new Enqueue( $this->loader, $this->enqueue );
		$enqueue->register_hooks();
	}

	/**
	 * Register all of the hooks related to the custom excerpt
	 *
	 * @since    2.0.0
	 * @access   private
	 * @return   void
	 */
	private function set_custom_excerpt() {
		$excerpt = new Excerpt( $this->loader, $this->excerpt );
		$excerpt->register_hooks();
	}

	/**
	 * Define the locale for this theme for internationalization.
	 *
	 * @since    2.0.0
	 * @access   private
	 * @return   void
	 */
	private function set_i18n() {
		$i18n = new Translations();
		$this->loader->add_action( 'themes_loaded', $i18n, 'load_textdomain' );
	}

	/**
	 * Register all of the hooks related to the custom image sizes for the theme
	 *
	 * @since    2.0.0
	 * @access   private
	 * @return   void
	 */
	private function set_custom_image() {
		$image = new Image( $this->loader, $this->image_sizes['default'], $this->image_sizes['custom'] );
		$image->register_hooks();
	}

	/**
	 * Register all of the hooks related to the meta for the theme
	 *
	 * @since    2.0.0
	 * @access   private
	 * @return   void
	 */
	private function set_meta() {
		$meta = new Meta( $this->loader );
		$meta->register_hooks();
	}

	/**
	 * Register all of the hooks related to security enhancements for the theme
	 *
	 * @since    2.0.0
	 * @access   private
	 * @return   void
	 */
	private function set_security() {
		$security = new Security( $this->loader );
		$security->register_hooks();
	}

	/**
	 * Register all of the hooks related to theme supports for the theme
	 *
	 * @since    2.0.0
	 * @access   private
	 * @return   void
	 */
	private function set_supports() {
		$supports = new Supports( $this->loader );
		$supports->register_hooks();
	}

	/**
	 * Register all of the hooks related to navigation menus for the theme
	 *
	 * @since    2.0.0
	 * @access   private
	 * @return   void
	 */
	private function set_navigation() {
		$navigation = new Navigation( $this->loader, $this->navigation );
		$navigation->register_hooks();
	}

	/**
	 * Register all of the hooks related to uploads for the theme
	 *
	 * @since    2.0.0
	 * @access   private
	 * @return   void
	 */
	private function set_uploads() {
		$uploads = new Uploads( $this->loader );
		$uploads->register_hooks();
	}
}
