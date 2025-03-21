<?php
/**
 * Utility functions for pages and settings
 *
 * @link       https://www.kotisivu.dev
 * @since      2.0.0
 *
 * @package    Vihersalo\BlockThemeCore\Support\Utils
 */

namespace Vihersalo\BlockThemeCore\Support\Utils;

defined( 'ABSPATH' ) || die();

use Vihersalo\BlockThemeCore\Support\Utils\Common as CommonUtils;

/**
 * Utility functions for pages and settings
 *
 * @since      2.0.0
 * @package    Vihersalo\BlockThemeCore\Support\Utils
 * @author     Heikki Vihersalo <heikki@vihersalo.fi>
 */
final class Pages {
	/**
	 * This utility class should never be instantiated.
	 */
	private function __construct() {
	}

	/**
	 * Include a callback file and return the output
	 *
	 * @param string $path The path to the file
	 * @param string $capability The capability required to view the page
	 */
	public static function callback( string $path, string $capability = 'manage_options' ) {
		if ( ! current_user_can( $capability ) ) {
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
	 * Localize the script with the data needed from the server
	 *
	 * @param string $handle The script handle to allow the data to be attached to
	 * @param string $object_name The name of the object (this is the name you will use to access the data in JavaScript)
	 * @param array  $l10n The data to localize the script with
	 *
	 * @return callable The localized script
	 */
	public static function localize( string $handle, string $object_name, array $l10n ) {
		return function () use ( $handle, $object_name, $l10n ) {
			wp_localize_script( $handle, $object_name, $l10n );
		};
	}
}
