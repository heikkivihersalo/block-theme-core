<?php

namespace Vihersalo\Core\Enqueue;

use Vihersalo\Core\Application;
use Vihersalo\Core\Application\HooksLoader;
use Vihersalo\Core\Support\Utils\Media as MediaUtils;
use Vihersalo\Core\Support\ServiceProvider;

/**
 *
 * @since      1.0.0
 * @package    Vihersalo\Core\Enqueue
 * @author     Heikki Vihersalo <heikki@vihersalo.fi>
 */
class EnqueueProvider extends ServiceProvider {
	/**
	 * Register the navigation provider
	 *
	 * @since    1.0.0
	 * @access   public
	 * @return void
	 */
	public function register() {
		$this->register_assets();
		$this->register_wp_media_support();
	}

	/**
	 * Register theme assets
	 *
	 * @since    1.0.0
	 * @access   public
	 * @return   void
	 */
	public function register_assets() {
		$assets = $this->app->make( 'config' )->get( 'app.assets' );

		foreach ( $assets as $asset ) :
			if ( method_exists( $asset, 'register' ) ) {
				call_user_func( [ $asset, 'register' ] );
			}
		endforeach;
	}

	/**
	 * Register WP media support
	 *
	 * @since    1.0.0
	 * @access   public
	 * @return   void
	 */
	public function register_wp_media_support() {
		$this->app->make( HooksLoader::class )->add_action( 'admin_enqueue_scripts', MediaUtils::class, 'add_wp_media_support' );
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
