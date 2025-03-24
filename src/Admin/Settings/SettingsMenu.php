<?php
/**
 *
 * @link       https://www.kotisivu.dev
 * @since      1.0.0
 *
 * @package    Vihersalo\Core\Support\Pages
 */

namespace Vihersalo\Core\Admin\Settings;

defined( 'ABSPATH' ) || die();

use Vihersalo\Core\Support\Assets\Localize;
use Vihersalo\Core\Admin\Settings\SettingsMenuBuilder;

/**
 *
 * @since      1.0.0
 * @package    Vihersalo\Core\Support\Pages
 * @author     Heikki Vihersalo <heikki@vihersalo.fi>
 */
class SettingsMenu {
	/**
	 * The slug of the menu
	 *
	 * @var string $slug The slug of the menu
	 */
	private $slug;

	/**
	 * The title of the page
	 *
	 * @var string $page_title The title of the page
	 */
	private $page_title;

	/**
	 * The title of the menu
	 *
	 * @var string $menu_title The title of the menu
	 */
	private $menu_title;

	/**
	 * The capability required to view the page
	 *
	 * @var string $capability The capability required to view the page
	 */
	private $capability;

	/**
	 * The icon of the menu
	 *
	 * @var string $icon The icon of the menu
	 */
	private $icon;

	/**
	 * The position of the menu
	 *
	 * @var int $position The position of the menu
	 */
	private $position;

	/**
	 * The callback function path
	 *
	 * @var string $path The callback function path
	 */
	private $path;

	/**
	 * The sub pages
	 *
	 * @var array $submenu The sub pages
	 */
	private $submenu;

	/**
	 * The assets
	 *
	 * @var array $assets The assets
	 */
	private $assets;

	/**
	 * The localize
	 *
	 * @var Localize|bool $localize The localize
	 */
	private $localize;

	/**
	 * Create a new page collection
	 *
	 * @param string        $slug The slug of the menu
	 * @param string        $page_title The title of the page
	 * @param string        $menu_title The title of the menu
	 * @param path          $path The callback function path
	 * @param string        $capability The capability required to view the page
	 * @param string        $icon The icon of the menu
	 * @param int           $position The position of the menu
	 * @param array         $sub_pages The sub pages
	 * @param array         $assets The assets
	 * @param Localize|bool $localize The localize
	 * @since 1.0.0
	 * @access private
	 * @return void
	 */
	public function __construct(
		$slug,
		$page_title,
		$menu_title,
		$path,
		$capability = 'manage_options',
		$icon = 'dashicons-admin-generic',
		$position = 50,
		$sub_pages = [],
		$assets = [],
		$localize = false
	) {
			$this->slug       = $slug;
			$this->page_title = $page_title;
			$this->menu_title = $menu_title;
			$this->path       = $path;
			$this->capability = $capability;
			$this->icon       = $icon;
			$this->position   = $position;
			$this->submenu    = $sub_pages;
			$this->assets     = $assets;
			$this->localize   = $localize;
	}

	/**
	 * Create a new page collection
	 *
	 * @param string $slug The slug of the menu
	 * @param string $page_title The title of the page
	 * @param string $menu_title The title of the menu
	 * @param string $path The callback function path
	 * @param string $capability The capability required to view the page
	 * @param string $icon The icon of the menu
	 * @param int    $position The position of the menu
	 * @return \Vihersalo\Core\Admin\Settings\SettingsMenuBuilder
	 */
	public static function configure(
		string $slug,
		string $page_title,
		string $menu_title,
		string $path,
		string $capability = 'manage_options',
		string $icon = 'dashicons-admin-generic',
		int $position = 50,
	) {
		return ( new SettingsMenuBuilder(
			new static( $slug, $page_title, $menu_title, $path, $capability, $icon, $position )
		) );
	}

	/**
	 * Get settings menu slug
	 *
	 * @return string
	 */
	public function get_slug() {
		return $this->slug;
	}

	/**
	 * Get settings menu page title
	 *
	 * @return string
	 */
	public function get_page_title() {
		return $this->page_title;
	}

	/**
	 * Get settings menu title
	 *
	 * @return string
	 */
	public function get_menu_title() {
		return $this->menu_title;
	}

	/**
	 * Get settings menu callback
	 *
	 * @return callable
	 */
	public function get_path() {
		return $this->path;
	}

	/**
	 * Get settings menu capability
	 *
	 * @return string
	 */
	public function get_capability() {
		return $this->capability;
	}

	/**
	 * Get settings menu icon
	 *
	 * @return string
	 */
	public function get_icon() {
		return $this->icon;
	}

	/**
	 * Get settings menu position
	 *
	 * @return int
	 */
	public function get_position() {
		return $this->position;
	}

	/**
	 * Get submenu pages
	 *
	 * @return array
	 */
	public function get_submenu() {
		return $this->submenu;
	}

	/**
	 * Get assets
	 *
	 * @return array
	 */
	public function get_assets() {
		return $this->assets;
	}

	/**
	 * Get localize
	 *
	 * @return Localize|bool
	 */
	public function get_localize() {
		return $this->localize;
	}

	/**
	 * Set submenu pages
	 *
	 * @param Vihersalo\Core\Support\Collections\MenuCollection $submenu The submenu pages
	 * @return void
	 */
	public function set_submenu( $submenu ) {
		$this->submenu = $submenu;
	}

	/**
	 * Set assets
	 *
	 * @param Vihersalo\Core\Support\Collections\AssetCollection $assets The assets
	 * @return void
	 */
	public function set_assets( $assets ) {
		$this->assets = $assets;
	}

	/**
	 * Set localize
	 *
	 * @param Localize|bool $localize The localize
	 * @return void
	 */
	public function set_localize( $localize ) {
		$this->localize = $localize;
	}
}
