<?php

namespace Vihersalo\BlockThemeCore\Admin;

use Vihersalo\BlockThemeCore\Application;
use Vihersalo\BlockThemeCore\Application\HooksLoader;
use Vihersalo\BlockThemeCore\Support\Utils\Common as Utils;
use Vihersalo\BlockThemeCore\Support\ServiceProvider;

/**
 *
 * @since      2.0.0
 * @package    Vihersalo\BlockThemeCore\Admin
 * @author     Heikki Vihersalo <heikki@vihersalo.fi>
 */
class CustomizerProvider extends ServiceProvider {
	/**
	 * Register the navigation provider
	 */
	public function register() {
		$this->enable_customizer();
	}

	/**
	 * Enable customizer
	 *
	 * @since    2.0.0
	 * @access   private
	 * @return   void
	 */
	private function enable_customizer() {
		$this->app->make( HooksLoader::class )->add_action( 'customize_register', Utils::class, 'return_true' );
	}

	/**
	 * Boot the navigation provider
	 */
	public function boot() {
	}
}
