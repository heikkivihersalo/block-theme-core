<?php

namespace Vihersalo\BlockThemeCore\Analytics;

use Vihersalo\BlockThemeCore\Application;
use Vihersalo\BlockThemeCore\Application\HooksLoader;
use Vihersalo\BlockThemeCore\Support\ServiceProvider;

/**
 *
 * @since      2.0.0
 * @package    Vihersalo\BlockThemeCore\Analytics
 * @author     Heikki Vihersalo <heikki@vihersalo.fi>
 */
class AnalyticsProvider extends ServiceProvider {
	/**
	 * Register the navigation provider
	 */
	public function register() {
		$this->register_tagmanager();
	}

	/**
	 * Register the Google Tag Manager
	 *
	 * @return void
	 */
	public function register_tagmanager() {
		$tagmanager = new TagManager();

		$this->app->make( HooksLoader::class )->add_action( 'wp_head', $tagmanager, 'inline_tag_manager', 0 );
	}

	/**
	 * Boot the navigation provider
	 */
	public function boot() {
	}
}
