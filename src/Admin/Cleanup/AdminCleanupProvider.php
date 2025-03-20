<?php

namespace Vihersalo\BlockThemeCore\Admin\Duplicate;

use Vihersalo\BlockThemeCore\Application;
use Vihersalo\BlockThemeCore\Application\HooksLoader;
use Vihersalo\BlockThemeCore\Admin\Cleanup\Utils;
use Vihersalo\BlockThemeCore\Support\ServiceProvider;

/**
 *
 * @since      2.0.0
 * @package    Vihersalo\BlockThemeCore\Admin\Duplicate
 * @author     Heikki Vihersalo <heikki@vihersalo.fi>
 */
class AdminCleanupProvider extends ServiceProvider {
	/**
	 * Register the navigation provider
	 */
	public function register() {
		$this->register_cleanup_functions( $this->app->make( HooksLoader::class ) );
	}

	/**
	 * Enable customizer
	 *
	 * @since    2.0.0
	 * @access   private
	 * @return   void
	 */
	protected function register_cleanup_functions( HooksLoader $loader ) {
		$loader->add_action( 'admin_bar_menu', Utils::class, 'remove_admin_bar_items' );
		$loader->add_action( 'admin_menu', Utils::class, 'set_default_dashboard_metaboxes' );
	}

	/**
	 * Boot the navigation provider
	 */
	public function boot() {
	}
}
