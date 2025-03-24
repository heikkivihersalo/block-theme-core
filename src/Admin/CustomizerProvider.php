<?php

namespace Vihersalo\Core\Admin;

use Vihersalo\Core\Application;
use Vihersalo\Core\Application\HooksLoader;
use Vihersalo\Core\Support\Utils\Common as Utils;
use Vihersalo\Core\Support\ServiceProvider;

/**
 *
 * @since      1.0.0
 * @package    Vihersalo\Core\Admin
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
	 * @since    1.0.0
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
