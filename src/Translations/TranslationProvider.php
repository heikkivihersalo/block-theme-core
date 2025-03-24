<?php

namespace Vihersalo\Core\Translations;

use Vihersalo\Core\Application;
use Vihersalo\Core\Application\HooksLoader;
use Vihersalo\Core\Support\ServiceProvider;

/**
 *
 * @since      1.0.0
 * @package    Vihersalo\Core\Navigation
 * @author     Heikki Vihersalo <heikki@vihersalo.fi>
 */
class TranslationProvider extends ServiceProvider {
	/**
	 * Register the navigation provider
	 *
	 * @since 1.0.0
	 * @access public
	 * @return void
	 */
	public function register() {
		$this->app->make( HooksLoader::class )->add_action( 'after_setup_theme', $this, 'load_textdomain' );
	}

	/**
	 * Load navigation menus
	 *
	 * @since 1.0.0
	 * @access public
	 * @return void
	 */
	public function load_textdomain(): void {
		$textdomain = $this->app->make( 'config' )->get( 'app.textdomain' );
		$path       = $this->app->make( 'config' )->get( 'app.path' );

		load_theme_textdomain( $textdomain, $path . '/languages' );
	}

	/**
	 * Boot the navigation provider
	 *
	 * @since 1.0.0
	 * @access public
	 * @return void
	 */
	public function boot() {
	}
}
