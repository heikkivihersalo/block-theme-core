<?php
/**
 * Utility functions for helper functions
 *
 * @link       https://www.kotisivu.dev
 * @since      2.0.0
 *
 * @package    Vihersalo\BlockThemeCore\Support\Utils
 */

namespace Vihersalo\BlockThemeCore\Support\Utils;

defined( 'ABSPATH' ) || die();

/**
 * Utility functions for helper functions
 *
 * @since      2.0.0
 * @package    Vihersalo\BlockThemeCore\Support\Utils
 * @author     Heikki Vihersalo <heikki@vihersalo.fi>
 */
final class Common {
	/**
	 * This utility class should never be instantiated.
	 */
	private function __construct() {
	}

	/**
	 * Return true
	 *
	 * @since 2.0.0
	 * @return bool
	 */
	public static function return_true(): bool {
		return true;
	}

	/**
	 * Return false
	 *
	 * @since 2.0.0
	 * @return bool
	 */
	public static function return_false(): bool {
		return false;
	}

	/**
	 * Check if the current page is the plugin's editor page
	 *
	 * @since    2.0.0
	 * @param string $hook The current admin page
	 * @return bool
	 */
	public static function is_editor_page( string $hook ): bool {
		return str_contains( $hook, 'post-new.php' ) || str_contains( $hook, 'post.php' );
	}

	/**
	 * Check if the current page is the plugin's editor page
	 *
	 * @since    2.0.0
	 * @param string $hook The current admin page
	 * @return bool
	 */
	public static function is_terms_page( string $hook ): bool {
		return str_contains( $hook, 'edit-tags.php' ) || str_contains( $hook, 'term.php' );
	}
}
