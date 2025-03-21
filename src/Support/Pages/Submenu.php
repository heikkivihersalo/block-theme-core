<?php
/**
 *
 * @link       https://www.kotisivu.dev
 * @since      2.0.0
 *
 * @package    Vihersalo\BlockThemeCore\Support\Pages
 */

namespace Vihersalo\BlockThemeCore\Support\Pages;

defined( 'ABSPATH' ) || die();

/**
 *
 * @since      2.0.0
 * @package    Vihersalo\BlockThemeCore\Support\Pages
 * @author     Heikki Vihersalo <heikki@vihersalo.fi>
 */
class Submenu {
	/**
	 * Constructor
	 *
	 * @param string $slug The slug of the menu
	 * @param string $page_title The title of the page
	 * @param string $menu_title The title of the menu
	 * @param string $capability The capability required to view the page
	 * @since 2.0.0
	 * @access private
	 * @return void
	 */
	public function __construct(
		private string $slug,
		private string $page_title,
		private string $menu_title,
		private string $capability = 'manage_options',
	) {
	}

	/**
	 * Create a new submenu
	 *
	 * @param string $slug The slug of the page
	 * @param string $page_title The title of the page
	 * @param string $menu_title The title of the menu
	 * @param string $capability The capability required to view the page
	 * @return self
	 */
	public static function create( string $slug, string $page_title, string $menu_title, string $capability ): self {
		return new self( $slug, $page_title, $menu_title, $capability );
	}

	/**
	 * Get the slug
	 *
	 * @return string The slug
	 */
	public function get_slug(): string {
		return $this->slug;
	}

	/**
	 * Get the page title
	 *
	 * @return string The page title
	 */
	public function get_page_title(): string {
		return $this->page_title;
	}

	/**
	 * Get the menu title
	 *
	 * @return string The menu title
	 */
	public function get_menu_title(): string {
		return $this->menu_title;
	}

	/**
	 * Get the capability
	 *
	 * @return string The capability
	 */
	public function get_capability(): string {
		return $this->capability;
	}
}
