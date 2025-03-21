<?php

namespace Vihersalo\BlockThemeCore\Styles;

use Vihersalo\BlockThemeCore\Application;
use Vihersalo\BlockThemeCore\Application\HooksLoader;
use Vihersalo\BlockThemeCore\Support\ServiceProvider;
use Vihersalo\BlockThemeCore\Styles\Scheme;

/**
 *
 * @since      2.0.0
 * @package    Vihersalo\BlockThemeCore\Analytics
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
	 * @since    2.0.0
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
