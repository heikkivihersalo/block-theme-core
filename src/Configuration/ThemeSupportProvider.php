<?php

namespace Vihersalo\Core\Configuration;

use Vihersalo\Core\Application;
use Vihersalo\Core\Application\HooksLoader;
use Vihersalo\Core\Support\ServiceProvider;

/**
 *
 * @since      1.0.0
 * @package    Vihersalo\Core\Configuration
 * @author     Heikki Vihersalo <heikki@vihersalo.fi>
 */
class ThemeSupportProvider extends ServiceProvider {
	/**
	 * Register the navigation provider
	 */
	public function register() {
		$this->app->make( HooksLoader::class )->add_action( 'after_setup_theme', $this, 'add_theme_supports' );
		$this->app->make( HooksLoader::class )->add_action( 'after_setup_theme', $this, 'remove_theme_supports' );
	}

	/**
	 * Set theme supports
	 *
	 * @since    1.0.0
	 * @access   public
	 * @return   void
	 */
	public function add_theme_supports() {
		$features = $this->app->make( 'config' )->get( 'app.theme_supports' );

		foreach ( $features as $feature ) :
			add_theme_support( $feature );
		endforeach;
	}

	/**
	 * Remove theme supports
	 *
	 * @since    1.0.0
	 * @access   public
	 * @return   void
	 */
	public function remove_theme_supports() {
		remove_theme_support( 'core-block-patterns' );
	}

	/**
	 * Boot the navigation provider
	 */
	public function boot() {
	}
}
