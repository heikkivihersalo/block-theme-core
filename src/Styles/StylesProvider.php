<?php

namespace Vihersalo\Core\Styles;

use Vihersalo\Core\Application;
use Vihersalo\Core\Application\HooksLoader;
use Vihersalo\Core\Support\ServiceProvider;
use Vihersalo\Core\Styles\Scheme;

/**
 *
 * @since      1.0.0
 * @package    Vihersalo\Core\Analytics
 * @author     Heikki Vihersalo <heikki@vihersalo.fi>
 */
class StylesProvider extends ServiceProvider {
	/**
	 * Register the navigation provider
	 */
	public function register() {
		$this->inline_meta_styles();
	}

	/**
	 * Register theme meta styles
	 *
	 * @since    1.0.0
	 * @access   public
	 * @return   void
	 */
	public function inline_meta_styles() {
		$color = $this->app->make( 'config' )->get( 'app.color' );

		$scheme = new Scheme( $color );

		$this->app->make( HooksLoader::class )->add_action( 'wp_head', $scheme, 'inline_theme_color', 0 );
	}

	/**
	 * Boot the navigation provider
	 */
	public function boot() {
	}
}
