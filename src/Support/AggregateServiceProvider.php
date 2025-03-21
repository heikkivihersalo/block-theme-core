<?php

namespace Vihersalo\BlockThemeCore\Support;

/**
 * The aggregate service provider class.
 *
 * @since      2.0.0
 * @package    Vihersalo\BlockThemeCore\Support
 * @author     Heikki Vihersalo <heikki@vihersalo.fi>
 */
class AggregateServiceProvider extends ServiceProvider {
	/**
	 * The provider class names.
	 *
	 * @var array
	 */
	protected $providers = [];

	/**
	 * An array of the service provider instances.
	 *
	 * @var array
	 */
	protected $instances = [];

	/**
	 * Register the service provider.
	 *
	 * @return void
	 */
	public function register() {
		$this->instances = [];

		foreach ( $this->providers as $provider ) {
			$this->instances[] = $this->app->register_provider( $provider );
		}
	}

	/**
	 * Get the services provided by the provider.
	 *
	 * @return array
	 */
	public function provides() {
		$provides = [];

		foreach ( $this->providers as $provider ) {
			$instance = $this->app->resolve_provider( $provider );

			$provides = array_merge( $provides, $instance->provides() );
		}

		return $provides;
	}
}
