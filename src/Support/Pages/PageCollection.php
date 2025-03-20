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
class PageCollection {
	/**
	 * The parent pages
	 * @var array
	 */
	public $parent_pages;

	/**
	 * The sub pages
	 * @var array
	 */
	public $sub_pages;

	/**
	 * Create a new page collection
	 *
	 * @param array $parent_pages The parent pages
	 * @param array $sub_pages The sub pages
	 */
	public function __construct( $parent_pages = array(), $sub_pages = array() ) {
		$this->parent_pages = $parent_pages;
		$this->sub_pages    = $sub_pages;
	}

	/**
	 * Get collection
	 */
	public function get_collection() {
		return array(
			'parent_pages' => $this->parent_pages,
			'sub_pages'    => $this->sub_pages,
		);
	}
}
