<?php

namespace Vihersalo\Core\Support\Utils;

defined( 'ABSPATH' ) || die();

/**
 * Utility functions for options
 *
 * @since      1.0.0
 * @package    Vihersalo\Core\Support\Utils
 * @author     Heikki Vihersalo <heikki@vihersalo.fi>
 */
final class Options {
	/**
	 * This utility class should never be instantiated.
	 */
	private function __construct() {
	}

	/**
	 * Get transient lifespan based on user role and app state
	 *
	 * @return int
	 */
	private static function get_transient_lifespan(): int {
		return ( is_super_admin() && \WP_DEBUG ) ? 1 : \DAY_IN_SECONDS;
	}

	/**
	 * Get site options from database and store it to cache
	 *
	 * @param string $slug The slug of the options
	 *
	 * @return mixed
	 */
	public static function get_options_file( string $slug ): mixed {
		/**
		 * Check options for cache. If not found, load it from database
		 */
		$cache = wp_cache_get( $slug );

		if ( false === $cache ) {
			$cache = get_option( $slug );
			wp_cache_set( $slug, $cache );
		}

		return $cache;
	}

	/**
	 * Purge transient cache
	 *
	 * @return void
	 */
	public static function purge_transient_cache(): void {
		global $wpdb;

		/**
		 * Get all transients that are related to Kotisivu Block Theme
		 */
		// phpcs:ignore -- We need to use direct query here
		$transients = $wpdb->get_col(
			$wpdb->prepare(
				'SELECT option_name FROM %i WHERE option_name LIKE %s',
				$wpdb->options, // Name of the options table
				'_transient_timeout_Vihersalo-block-theme-core%'
			)
		);

		/**
		 * Delete all transients
		 */
		foreach ( $transients as $transient ) {
			$key = str_replace( '_transient_timeout_', '', $transient );
			delete_transient( $key );
		}

		wp_cache_flush();
	}
}
