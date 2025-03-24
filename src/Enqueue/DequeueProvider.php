<?php

namespace Vihersalo\Core\Enqueue;

use Vihersalo\Core\Application;
use Vihersalo\Core\Application\HooksLoader;
use Vihersalo\Core\Support\ServiceProvider;

/**
 *
 * @since      1.0.0
 * @package    Vihersalo\Core\Enqueue
 * @author     Heikki Vihersalo <heikki@vihersalo.fi>
 */
class DequeueProvider extends ServiceProvider {
	/**
	 * Register the navigation provider
	 *
	 * @since    1.0.0
	 * @access   public
	 * @return void
	 */
	public function register() {
		$this->app->make( HooksLoader::class )->add_action( 'wp_enqueue_scripts', $this, 'dequeue_assets' );
	}

	/**
	 * Register theme assets
	 *
	 * @since    1.0.0
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
	 * @since    1.0.0
	 * @access   public
	 * @return void
	 */
	public function boot() {
	}
}
