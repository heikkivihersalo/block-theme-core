<?php

namespace HeikkiVihersalo\BlockThemeCore;

use Illuminate\Container\Container;

use HeikkiVihersalo\BlockThemeCore\Application\ApplicationBuilder;
use HeikkiVihersalo\BlockThemeCore\Configuration\Config;
use HeikkiVihersalo\BlockThemeCore\Navigation\NavigationServiceProvider;

/**
 * The core application class.
 *
 * @since      2.0.0
 * @package    HeikkiVihersalo\BlockThemeCore
 * @author     Heikki Vihersalo
 */
class Application extends Container {
	/**
	 * The instance of the container
	 * @var Container
	 */
	protected static $container;

	/**
	 * The path to the application "app" base directory.
	 * @var string
	 */
	protected $base_path;

	/**
	 * The URI to the application "app" base directory.
	 * @var string
	 */
	protected $base_uri;

	/**
	 * All of the registered service providers.
	 *
	 * @var array<string, \Illuminate\Support\ServiceProvider>
	 */
	protected $serviceProviders = array();

	/**
	 * Constructor
	 */
	public function __construct( $base_path = null, $base_uri = null ) {
		$this->base_path = $base_path ?? get_template_directory();
		$this->base_uri  = $base_uri ?? get_template_directory_uri();

		$this->register_base_bindings();
		$this->register_base_service_providers();
	}

	/**
	 * Configure the application
	 *
	 * @return ApplicationBuilder
	 */
	public static function configure() {
		return new ApplicationBuilder( new static() );
	}

	/**
	 * Get the registered service provider instance if it exists.
	 *
	 * @param  \Illuminate\Support\ServiceProvider|string $provider
	 * @return \Illuminate\Support\ServiceProvider|null
	 */
	public function get_provider( $provider ) {
		$name = is_string( $provider ) ? $provider : get_class( $provider );

		return $this->serviceProviders[ $name ] ?? null;
	}

	/**
	 * Resolve a service provider instance from the class name.
	 *
	 * @param  string $provider
	 * @return \Illuminate\Support\ServiceProvider
	 */
	public function resolve_provider( $provider ) {
		return new $provider( $this );
	}

	/**
	 * Get the instance of the container
	 *
	 * @return Container
	 */
	protected function register_base_bindings() {
		static::$container = static::setInstance( $this );

		$this->instance( 'app', $this );
		$this->instance( Container::class, $this );

		// Bind the application config files to the container
		$this->singleton(
			'config',
			function () {
				return new Config( $this->base_path . '/config' );
			}
		);

		// Bind the application loader to the container
		$this->singleton(
			Loader::class,
			function () {
				return new Loader();
			}
		);
	}

	/**
	 * Register the base service providers
	 *
	 * @return void
	 */
	protected function register_base_service_providers() {
		$this->register( new NavigationServiceProvider( $this ) );
	}

	/**
	 * Register a service provider with the application.
	 *
	 * @param  \Illuminate\Support\ServiceProvider|string $provider
	 * @param  bool                                       $force
	 * @return \Illuminate\Support\ServiceProvider
	 */
	public function register( $provider, $force = false ) {
		if ( ( $registered = $this->get_provider( $provider ) ) && ! $force ) {
			return $registered;
		}

		// If the given "provider" is a string, we will resolve it, passing in the
		// application instance automatically for the developer. This is simply
		// a more convenient way of specifying your service provider classes.
		if ( is_string( $provider ) ) {
			$provider = $this->resolve_provider( $provider );
		}

		$provider->register();

		// If there are bindings / singletons set as properties on the provider we
		// will spin through them and register them with the application, which
		// serves as a convenience layer while registering a lot of bindings.
		if ( property_exists( $provider, 'bindings' ) ) {
			foreach ( $provider->bindings as $key => $value ) {
				$this->bind( $key, $value );
			}
		}

		if ( property_exists( $provider, 'singletons' ) ) {
			foreach ( $provider->singletons as $key => $value ) {
				$key = is_int( $key ) ? $value : $key;

				$this->singleton( $key, $value );
			}
		}

		// $this->markAsRegistered($provider);

		// // If the application has already booted, we will call this boot method on
		// // the provider class so it has an opportunity to do its boot logic and
		// // will be ready for any usage by this developer's application logic.
		// if ($this->isBooted()) {
		// $this->bootProvider($provider);
		// }

		return $provider;
	}

	/**
	 * Get the configuration value
	 *
	 * @param string $key
	 * @return mixed
	 */
	protected function config( $key ) {
		return $this->make( Config::class )->get( $key );
	}
}
