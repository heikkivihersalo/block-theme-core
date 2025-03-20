<?php

namespace Vihersalo\BlockThemeCore\Enqueue;

use Vihersalo\BlockThemeCore\Application;
use Vihersalo\BlockThemeCore\Application\HooksLoader;
use Vihersalo\BlockThemeCore\Support\ServiceProvider;

/**
 *
 * @since      2.0.0
 * @package    Vihersalo\BlockThemeCore\Enqueue
 * @author     Heikki Vihersalo <heikki@vihersalo.fi>
 */
class EnqueueProvider extends ServiceProvider {
	/**
	 * Register the navigation provider
	 *
	 * @since    2.0.0
	 * @access   public
	 * @return void
	 */
	public function register() {
		$this->register_assets();
	}

	/**
	 * Register theme assets
	 *
	 * @since    2.0.0
	 * @access   public
	 * @return   void
	 */
	public function register_assets() {
		$assets = $this->app->make( 'config' )->get( 'app.assets' );

		foreach ( $assets as $asset ) :
			if ( method_exists( $asset, 'register' ) ) {
				call_user_func( array( $asset, 'register' ) );
			}
		endforeach;
	}

	/**
	 * Boot the navigation provider
	 *
	 * @since    2.0.0
	 * @access   public
	 * @return void
	 */
	public function boot() {
	}
}
