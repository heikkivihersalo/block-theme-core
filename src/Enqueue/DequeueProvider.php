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
class DequeueProvider extends ServiceProvider {
	/**
	 * Register the navigation provider
	 *
	 * @since    2.0.0
	 * @access   public
	 * @return void
	 */
	public function register() {
		$this->dequeue_assets();
	}

	/**
	 * Register theme assets
	 *
	 * @since    2.0.0
	 * @access   public
	 * @return   void
	 */
	public function dequeue_assets() {
		$dequeue = $this->app->make( 'config' )->get( 'app.dequeue' );

		foreach ( $dequeue as $asset ) :
			if ( ! is_string( $asset ) ) {
				continue;
			}

			wp_deregister_style( $asset );
			wp_dequeue_style( $asset );
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
