<?php
/**
 *
 * @link       https://www.kotisivu.dev
 * @since      2.0.0
 *
 * @package    HeikkiVihersalo\BlockThemeCore\Media
 */

namespace Vihersalo\BlockThemeCore\Admin\Pages;

defined( 'ABSPATH' ) || die();

/**
 *
 * @since      2.0.0
 * @package    HeikkiVihersalo\BlockThemeCore\Media
 * @author     Heikki Vihersalo <heikki@vihersalo.fi>
 */
class Page {
	/**
	 * Constructor
	 *
	 * @param string $slug The slug of the menu
	 * @param string $page_title The title of the page
	 * @param string $menu_title The title of the menu
	 * @param string $capability The capability required to view the page
	 * @param string $parent_slug The slug of the parent menu
	 * @param string $icon The icon of the menu
	 * @param int    $position The position of the menu
	 * @since 2.0.0
	 * @access private
	 * @return void
	 */
	public function __construct(
		private string $slug,
		private string $page_title,
		private string $menu_title,
		private string $capability = 'manage_options',
		private string $parent_slug = '',
		private string $icon = 'dashicons-admin-generic',
		private int $position = 50,
	) {
	}

	/**
	 * Get the slug of the page
	 *
	 * @return string
	 */
	public function get_slug(): string {
		return $this->slug;
	}

	/**
	 * Get the title of the page
	 *
	 * @return string
	 */
	public function get_page_title(): string {
		return $this->page_title;
	}

	/**
	 * Get the title of the menu
	 *
	 * @return string
	 */
	public function get_menu_title(): string {
		return $this->menu_title;
	}

	/**
	 * Get the slug of the parent menu
	 *
	 * @return string
	 */
	public function get_parent_slug(): string {
		return $this->parent_slug;
	}

	/**
	 * Get the capability required to view the page
	 *
	 * @return string
	 */
	public function get_capability(): string {
		return $this->capability;
	}

	/**
	 * Get the icon of the menu
	 *
	 * @return string
	 */
	public function get_icon(): string {
		return $this->icon;
	}

	/**
	 * Get the position of the menu
	 *
	 * @return int
	 */
	public function get_position(): int {
		return $this->position;
	}
}
