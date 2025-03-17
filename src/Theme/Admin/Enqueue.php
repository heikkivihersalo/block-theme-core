<?php
/**
 *
 *
 * @link       https://www.kotisivu.dev
 * @since      2.0.0
 *
 * @package    HeikkiVihersalo\BlockThemeCore\Theme\Admin\Enqueue
 */

namespace HeikkiVihersalo\BlockThemeCore\Theme\Admin;

use HeikkiVihersalo\BlockThemeCore\Theme\Common\Enqueue as CommonEnqueue;
use HeikkiVihersalo\BlockThemeCore\Theme\Common\Utils\Helpers;
use HeikkiVihersalo\BlockThemeCore\Theme\Common\Interfaces\EnqueueInterface;

/**
 *
 * @since      2.0.0
 * @package    HeikkiVihersalo\BlockThemeCore\Theme\Admin\Enqueue
 * @author     Heikki Vihersalo <heikki@vihersalo.fi>
 */
class Enqueue extends CommonEnqueue implements EnqueueInterface {
	/**
	 * Run the editor scripts and styles
	 *
	 * @since    0.2.0
	 * @param string $hook The current admin page
	 * @return void
	 */
	public function enqueue_scripts_and_styles( string $hook = '' ): void {
		if ( Helpers::is_editor_page( $hook ) || Helpers::is_terms_page( $hook ) ) {
			$asset_path = SITE_PATH . '/build/assets/admin.asset.php';
			$script_url = SITE_URI . '/build/assets/admin.js';
			$style_url  = SITE_URI . '/build/assets/admin.css';

			$this->enqueue_style( $asset_path, $style_url, 'ksd-admin' );
			$this->enqueue_script( $asset_path, $script_url, 'ksd-admin' );
		}
	}

	/**
	 * Add editor styles
	 *
	 * @return void
	 */
	public function set_editor_styles(): void {
		add_editor_style( SITE_URI . '/build/assets/theme.css' );
		add_editor_style( SITE_URI . '/build/assets/admin.css' );
		add_editor_style( SITE_URI . '/build/assets/core.css' );
		add_editor_style( SITE_URI . '/build/assets/inline.css' );
	}
}
