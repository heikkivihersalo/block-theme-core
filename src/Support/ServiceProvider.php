<?php

namespace Vihersalo\BlockThemeCore\Support;

use Closure;
use Vihersalo\BlockThemeCore\Application;

/**
 * The service provider class.
 *
 * @since      2.0.0
 * @package    Vihersalo\BlockThemeCore\Support
 * @author     Heikki Vihersalo <heikki@vihersalo.fi>
 */
abstract class ServiceProvider {
	/**
	 * The application instance.
	 *
	 * @var \Vihersalo\BlockThemeCore\Application
	 */
	protected $app;

	/**
	 * All of the registered booting callbacks.
	 *
	 * @var array
	 */
	protected $booting_callbacks = [];

	/**
	 * All of the registered booted callbacks.
	 *
	 * @var array
	 */
	protected $booted_callbacks = [];

	/**
	 * Create a new service provider instance.
	 *
	 * @param  \Vihersalo\BlockThemeCore\Application $app The application instance.
	 * @return void
	 */
	public function __construct( $app ) {
		$this->app = $app;
	}

	/**
	 * Register any application services.
	 *
	 * @return void
	 */
	public function register() {
	}

	/**
	 * Register a booting callback to be run before the "boot" method is called.
	 *
	 * @param  \Closure $callback The callback to run when the application is booting
	 * @return void
	 */
	public function booting( Closure $callback ) {
		$this->booting_callbacks[] = $callback;
	}

	/**
	 * Register a booted callback to be run after the "boot" method is called.
	 *
	 * @param  \Closure $callback The callback to run when the application has booted
	 * @return void
	 */
	public function booted( Closure $callback ) {
		$this->booted_callbacks[] = $callback;
	}

	/**
	 * Call the registered booting callbacks.
	 *
	 * @return void
	 */
	public function call_booting_callbacks() {
		$index = 0;

		while ( $index < count( $this->booting_callbacks ) ) {
			$this->app->call( $this->booting_callbacks[ $index ] );

			++$index;
		}
	}

	/**
	 * Call the registered booted callbacks.
	 *
	 * @return void
	 */
	public function call_booted_callbacks() {
		$index = 0;

		while ( $index < count( $this->booted_callbacks ) ) {
			$this->app->call( $this->booted_callbacks[ $index ] );

			++$index;
		}
	}

	/**
	 * Setup an after resolving listener, or fire immediately if already resolved.
	 *
	 * @param  string   $name    The name of the binding
	 * @param  callable $callback The callback to run when the binding is resolved
	 * @return void
	 */
	protected function call_after_resolving( $name, $callback ) {
		$this->app->afterResolving( $name, $callback );

		if ( $this->app->resolved( $name ) ) {
			$callback( $this->app->make( $name ), $this->app );
		}
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides() {
		return [];
	}

	/**
	 * Get the events that trigger this service provider to register.
	 *
	 * @return array
	 */
	public function when() {
		return [];
	}

	/**
	 * Get the default providers for a Laravel application.
	 *
	 * @return \Illuminate\Support\DefaultProviders
	 */
	public static function default_providers() {
		return new DefaultProviders();
	}
}
