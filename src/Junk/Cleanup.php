<?php
/**
 * Functions to clean up the theme from unnecessary WordPress junk
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
use HeikkiVihersalo\BlockThemeCore\Theme\Common\Utils\Helpers as HelpersUtils;
use HeikkiVihersalo\BlockThemeCore\Theme\Common\Utils\Performance as PerformanceUtils;
use HeikkiVihersalo\BlockThemeCore\Theme\Common\Interfaces\RegisterHooksInterface;

/**
 * Functions to clean up the theme from unnecessary WordPress junk
 *
 * @since      2.0.0
 * @package    HeikkiVihersalo\BlockThemeCore\Theme
 * @author     Heikki Vihersalo <heikki@vihersalo.fi>
 */
class Cleanup implements RegisterHooksInterface {
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
	 * Register all of the hooks related to the optimized jQuery
	 *
	 * @since    2.0.0
	 * @access   private
	 * @return   void
	 */
	private function set_jquery_optimizations() {
		$this->loader->add_action( 'wp_default_scripts', PerformanceUtils::class, 'remove_jquery_migrate' );
		$this->loader->add_action( 'wp_enqueue_scripts', PerformanceUtils::class, 'move_jquery_to_footer' );
	}

	/**
	 * Remove WP duotone filters
	 *
	 * @since    2.0.0
	 * @access   private
	 * @return   void
	 */
	public function remove_duotone_filters() {
		remove_action( 'wp_body_open', 'wp_global_styles_render_svg_filters' );
		remove_action( 'in_admin_header', 'wp_global_styles_render_svg_filters' );
	}

	/**
	 * Remove WP default junk
	 *
	 * @since    2.0.0
	 * @access   private
	 * @return   void
	 */
	private function remove_wp_default_junk() {
		/**
		 * Remove canonical links
		 */
		$this->loader->remove_action( 'embed_head', 'rel_canonical' );
		$this->loader->remove_action( 'wp_head', 'rel_canonical' );
		$this->loader->add_filter( 'wpseo_canonical', null, '__return_false' );

		/**
		 * Remove feed links
		 */
		$this->loader->remove_action( 'wp_head', 'feed_links', 2 );
		$this->loader->remove_action( 'wp_head', 'feed_links_extra', 3 );

		/**
		 * Remove gravatar
		 */
		$this->loader->add_filter( 'get_avatar', null, '__return_false' );
		$this->loader->add_filter( 'option_show_avatars', null, '__return_false' );

		/**
		 * Remove next and previous links
		 */
		$this->loader->remove_action( 'wp_head', 'adjacent_posts_rel_link', 10 );
		$this->loader->remove_action( 'wp_head', 'adjacent_posts_rel_link_wp_head', 10 );

		/**
		 * Remove RSD link
		 */
		$this->loader->remove_action( 'wp_head', 'rsd_link' );

		/**
		 * Remove shortlink
		 */
		$this->loader->remove_action( 'wp_head', 'wp_shortlink_wp_head', 10 );
		$this->loader->remove_action( 'template_redirect', 'wp_shortlink_header', 11 );
	}

	/**
	 * Remove WP emojis
	 *
	 * @since    2.0.0
	 * @access   private
	 * @return   void
	 */
	private function remove_wp_emojis() {
		$this->loader->remove_action( 'wp_head', 'print_emoji_detection_script', 7 );
		$this->loader->remove_action( 'admin_print_scripts', 'print_emoji_detection_script' );
		$this->loader->remove_action( 'wp_print_styles', 'print_emoji_styles' );
		$this->loader->remove_action( 'admin_print_styles', 'print_emoji_styles' );

		$this->loader->remove_filter( 'wp_mail', 'wp_staticize_emoji_for_email' );
		$this->loader->remove_filter( 'the_content_feed', 'wp_staticize_emoji' );
		$this->loader->remove_filter( 'comment_text_rss', 'wp_staticize_emoji' );

		$this->loader->add_filter( 'tiny_mce_plugins', PerformanceUtils::class, 'disable_emojis_tinymce' );
		$this->loader->add_filter( 'emoji_svg_url', HelpersUtils::class, 'return_false' );
		$this->loader->add_filter( 'wp_resource_hints', PerformanceUtils::class, 'disable_emojis_remove_dns_prefetch', 1, 2 );
	}

	/**
	 * @inheritDoc
	 */
	public function register_hooks() {
		$this->set_jquery_optimizations();
		$this->remove_wp_default_junk();
		$this->remove_wp_emojis();
		$this->loader->add_action( 'after_setup_theme', $this, 'remove_duotone_filters' );
	}
}
