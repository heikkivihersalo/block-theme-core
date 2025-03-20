<?php
/**
 *
 * @link       https://www.kotisivu.dev
 * @since      2.0.0
 *
 * @package    HeikkiVihersalo\BlockThemeCore\Media
 */

namespace Vihersalo\BlockThemeCore\Support\Pages;

defined( 'ABSPATH' ) || die();

use Vihersalo\BlockThemeCore\Admin\Pages\Page;

/**
 *
 * @since      2.0.0
 * @package    HeikkiVihersalo\BlockThemeCore\Media
 * @author     Heikki Vihersalo <heikki@vihersalo.fi>
 */
class SubPage extends Page {
	/**
	 * Create a new page
	 *
	 * @param string $slug The slug of the page
	 * @param string $page_title The title of the page
	 * @param string $menu_title The title of the menu
	 * @param string $capability The capability required to view the page
	 * @param string $parent_slug The slug of the parent menu
	 * @param int    $position The position of the menu
	 * @return self
	 */
	public static function create( string $slug, string $page_title, string $menu_title, string $capability, string $parent_slug ): self {
		return new self( $slug, $page_title, $menu_title, $capability, $parent_slug, '', 50 );
	}
}
