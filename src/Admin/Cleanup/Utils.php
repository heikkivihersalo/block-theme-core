<?php
/**
 * Class for cleaning up the theme admin panel
 *
 * @link       https://www.kotisivu.dev
 * @since      2.0.0
 *
 * @package    HeikkiVihersalo\BlockThemeCore\Theme\Admin\Pages
 */

namespace Vihersalo\BlockThemeCore\Admin\Cleanup;

defined( 'ABSPATH' ) || die();

/**
 * Class for cleaning up the theme admin panel
 *
 * @since      2.0.0
 * @package    HeikkiVihersalo\BlockThemeCore\Theme\Admin\Pages
 * @author     Heikki Vihersalo <heikki@vihersalo.fi>
 */
final class Utils {
	/**
	 * This utility class should never be instantiated.
	 */
	private function __construct() {
	}

	/**
	 * Set default dashboard metaboxes
	 *
	 * @param int $user_id User ID
	 * @return void
	 */
	public static function set_default_dashboard_metaboxes( $user_id = null ) {
		if ( ! $user_id ) {
			$user_id = get_current_user_id();
		}

		$meta_key = 'metaboxhidden_dashboard';

		if ( ! get_user_option( $meta_key, $user_id ) ) {
			update_user_option(
				$user_id,
				$meta_key,
				[
					'dashboard_site_health',
					'dashboard_right_now',
					'dashboard_activity',
					'dashboard_quick_press',
					'dashboard_primary',
					'llar_stats_widget', // Limit Login Attempts Reloaded plugin
					'fluentform_stat_widget', // Fluent Forms plugin
				],
				true
			);
		}
	}

	/**
	 * Remove admin bar items
	 *
	 * @return void
	 */
	public static function remove_admin_bar_items() {
		global $wp_admin_bar;

		$options = [
			'wp-logo'      => [
				'remove'   => true,
				'children' => [
					'about'         => true,
					'wporg'         => true,
					'documentation' => true,
					'support-forum' => true,
					'feedback'      => true,
				],
			],
			'site-name'    => [
				'remove'   => false,
				'children' => [
					'dashboard' => false,
					'themes'    => true,
					'menus'     => true,
				],
			],
			'updates'      => [
				'remove'   => true,
				'children' => [],
			],
			'site-editor'  => [
				'remove'   => true,
				'children' => [],
			],
			'customize'    => [
				'remove'   => false,
				'children' => [],
			],
			'comments'     => [
				'remove'   => true,
				'children' => [],
			],
			'new-content'  => [
				'remove'   => true,
				'children' => [],
			],
			'new-post'     => [
				'remove'   => true,
				'children' => [],
			],
			'new-media'    => [
				'remove'   => true,
				'children' => [],
			],
			'new-page'     => [
				'remove'   => true,
				'children' => [],
			],
			'new-user'     => [
				'remove'   => true,
				'children' => [],
			],
			'edit'         => [
				'remove'   => false,
				'children' => [],
			],
			'user-actions' => [ // to the right - next to your avatar image
				'remove'   => false,
				'children' => [
					'user-info'    => false,
					'edit-profile' => false,
					'logout'       => false,
				],
			],
			'search'       => [
				'remove'   => true,
				'children' => [],
			],
			'llar-root'    => [ // Limit Login Attempts Reloaded Plugin
				'remove'   => true,
				'children' => [],
			],
		];

		foreach ( $options as $key => $value ) {
			if ( $value['remove'] ) {
				$wp_admin_bar->remove_menu( $key );
			} else {
				foreach ( $value['children'] as $child => $remove ) {
					if ( $remove ) {
						$wp_admin_bar->remove_menu( $child );
					}
				}
			}
		}
	}
}
