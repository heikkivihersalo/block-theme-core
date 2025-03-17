<?php
/**
 *
 * @link       https://www.kotisivu.dev
 * @since      2.0.0
 *
 * @package    HeikkiVihersalo\BlockThemeCore\Theme\Navigation
 */

namespace HeikkiVihersalo\BlockThemeCore\Theme\Navigation;

defined( 'ABSPATH' ) || die();

/**
 *
 * @since      2.0.0
 * @package    HeikkiVihersalo\BlockThemeCore\Theme\Navigation
 * @author     Heikki Vihersalo <heikki@vihersalo.fi>
 */
class NavigationMenu {
	/**
	 * Slug of the menu
	 *
	 * @var string
	 */
	private string $slug;

	/**
	 * Name of the menu
	 *
	 * @var string
	 */
	private string $name;

	/**
	 * Constructor
	 *
	 * @param string $slug Slug of the menu
	 * @param string $name Name of the menu
	 */
	public function __construct( string $slug, string $name ) {
		$this->slug = $slug;
		$this->name = $name;
	}

	/**
	 * Get the slug of the menu
	 *
	 * @return string
	 */
	public function get_slug(): string {
		return $this->slug;
	}

	/**
	 * Get the name of the menu
	 *
	 * @return string
	 */
	public function get_name(): string {
		return $this->name;
	}

	/**
	 * Get the navigation menu
	 *
	 * @return array
	 */
	public function get_navigation_menu(): array {
		return array(
			$this->get_slug() => $this->get_name(),
		);
	}
}
