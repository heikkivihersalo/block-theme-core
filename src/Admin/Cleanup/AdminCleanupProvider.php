<?php

namespace Vihersalo\Core\Admin\Duplicate;

use Vihersalo\Core\Application;
use Vihersalo\Core\Application\HooksLoader;
use Vihersalo\Core\Admin\Cleanup\Utils;
use Vihersalo\Core\Support\ServiceProvider;

/**
 *
 * @since      1.0.0
 * @package    Vihersalo\Core\Admin\Duplicate
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
	 * @since    1.0.0
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
