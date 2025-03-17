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
	 * Constructor
	 *
	 * @param string $slug The slug of the menu
	 * @param string $name The name of the menu
	 * @since 2.0.0
	 * @access private
	 * @return void
	 */
	public function __construct( private string $slug, private string $name ) {
	}

	public static function create( string $slug, string $name ): self {
		return new self( $slug, $name );
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
}
