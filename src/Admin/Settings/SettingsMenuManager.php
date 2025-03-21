<?php
/**
 * Class for setting up the theme options
 *
 * @link       https://www.kotisivu.dev
 * @since      2.0.0
 *
 * @package    HeikkiVihersalo\BlockThemeCore\Theme\Admin\Pages
 */

namespace Vihersalo\BlockThemeCore\Admin\Settings;

defined( 'ABSPATH' ) || die();

use Vihersalo\BlockThemeCore\Support\Utils\Common as CommonUtils;

/**
 * Class for setting up the theme options
 *
 * @since      2.0.0
 * @package    HeikkiVihersalo\BlockThemeCore\Theme\Admin\Pages
 * @author     Heikki Vihersalo <heikki@vihersalo.fi>
 */
class SettingsMenuManager {
	/**
	 * Admin pages
	 *
	 * @var SettingsMenu $page The settings menu
	 */
	private $page;

	/**
	 * Base path
	 * @var string
	 */
	private $path;

	/**
	 * Base URI
	 * @var string
	 */
	private $uri;

	/**
	 * Constructor
	 *
	 * @since    2.0.0
	 * @access   public
	 */
	public function __construct( SettingsMenu $page, string $path, string $uri ) {
		$this->page = $page;
		$this->path = $path;
		$this->uri  = $uri;
	}

	/**
	 * Get the page ID from the menu title
	 * - Page title is generated from the menu title by replacing spaces with dashes
	 *   and converting the string to lowercase
	 *
	 * @param string $menu_title The menu title
	 * @return string The page ID
	 */
	public function get_page_id( $menu_title ) {
		return str_replace( ' ', '-', strtolower( $menu_title ) );
	}

	/**
	 * Get the prefix for the top level page
	 *
	 * @return string The prefix for the top level page
	 */
	public function get_toplevel_page_prefix() {
		return 'toplevel_page_';
	}

	/**
	 * Check if the current page is a custom admin page
	 *
	 * @param string $hook The current admin page
	 * @return bool
	 */
	public function is_custom_admin_page( $hook ): bool {
		$is_top_level = str_contains( $hook, $this->get_toplevel_page_prefix() . $this->page->get_slug() );
		$is_sub_page  = false;

		$submenu = $this->page->get_submenu();

		if ( $submenu ) {
			foreach ( $submenu as $subpage ) {
				$is_sub_page = str_contains( $hook, $subpage->get_slug() ) ? true : $is_sub_page;
			}
		}

		return $is_top_level || $is_sub_page;
	}

	/**
	 * Callback function for the admin page
	 *
	 * @since    2.0.0
	 * @access   public
	 */
	public function callback() {
		$path = $this->path . '/' . $this->page->get_path();

		if ( ! current_user_can( $this->page->get_capability() ) ) {
			wp_die( 'You do not have sufficient permissions to access this page' );
		}

		if ( ! CommonUtils::asset_exists( $path ) ) {
			return;
		}

		ob_start();
		require $path;
		echo ob_get_clean();
	}

	/**
	 * Add the menu
	 *
	 * @since    2.0.0
	 * @access   public
	 */
	public function add_menu() {
		add_menu_page(
			$this->page->get_page_title(),
			$this->page->get_menu_title(),
			$this->page->get_capability(),
			$this->page->get_slug(),
			[ $this, 'callback' ],
			$this->page->get_icon(),
			$this->page->get_position()
		);

		$submenu = $this->page->get_submenu();

		if ( ! $submenu ) {
			return;
		}

		foreach ( $submenu as $subpage ) {
			add_submenu_page(
				$this->page->get_slug(),
				$subpage->get_page_title(),
				$subpage->get_menu_title(),
				$subpage->get_capability(),
				$subpage->get_slug(),
				[ $this, 'callback' ]
			);
		}
	}

	/**
	 * Enqueue theme option related assets
	 * @param string $hook The current admin page
	 * @return void
	 */
	public function enqueue_assets( $hook ) {
		if ( ! $this->is_custom_admin_page( $hook ) ) {
			return;
		}
		$assets = $this->page->get_assets();

		foreach ( $assets as $asset ) :
			if ( method_exists( $asset, 'register' ) ) {
				call_user_func( [ $asset, 'register' ] );
			}
		endforeach;

		/**
		 * Localize the script with the data needed for the REST API
		 */
		$localize = $this->page->get_localize();

		if ( ! $localize ) {
			return;
		}

		if ( method_exists( $localize, 'register' ) ) {
			call_user_func( [ $localize, 'register' ] );
		}
	}
}
