<?php

namespace Vihersalo\Core\Analytics;

use Vihersalo\Core\Application;
use Vihersalo\Core\Application\HooksLoader;
use Vihersalo\Core\Support\ServiceProvider;

/**
 *
 * @since      1.0.0
 * @package    Vihersalo\Core\Analytics
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
