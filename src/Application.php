<?php

namespace Vihersalo\Core;

use Illuminate\Container\Container;

use Vihersalo\Core\Admin\CustomizerProvider;
use Vihersalo\Core\Admin\Duplicate\DuplicateProvider;
use Vihersalo\Core\Application\ApplicationBuilder;
use Vihersalo\Core\Application\HooksLoader;
use Vihersalo\Core\Configuration\Config;
use Vihersalo\Core\Configuration\ThemeSupportProvider;
use Vihersalo\Core\Enqueue\DequeueProvider;
use Vihersalo\Core\Enqueue\EnqueueProvider;
use Vihersalo\Core\Navigation\NavigationProvider;
use Vihersalo\Core\Translations\TranslationProvider;
use Vihersalo\Core\Support\ServiceProvider;

/**
 * The core application class.
 *
 * @since      1.0.0
 * @package    Vihersalo\Core
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
	 * Indicates if the application has "booted".
	 *
	 * @var bool
	 */
	protected $booted = false;

	/**
	 * The array of registered callbacks.
	 *
	 * @var callable[]
	 */
	protected $registered_callbacks = [];

	/**
	 * The array of booting callbacks.
	 *
	 * @var callable[]
	 */
	protected $booting_callbacks = [];

	/**
	 * The array of booted callbacks.
	 *
	 * @var callable[]
	 */
	protected $booted_callbacks = [];

	/**
	 * All of the registered service providers.
	 *
	 * @var array<string, \Illuminate\Support\ServiceProvider>
	 */
	protected $service_providers = [];

	/**
	 * The names of the loaded service providers.
	 *
	 * @var array
	 */
	protected $loaded_providers = [];

	/**
	 * Constructor
	 *
	 * @param string $base_path The path to the application "app" base directory
	 * @param string $base_uri The URI to the application "app" base directory
	 * @return void
	 */
	public function __construct( $base_path = null, $base_uri = null ) {
		$this->base_path = $base_path ?? get_template_directory();
		$this->base_uri  = $base_uri ?? get_template_directory_uri();

		$this->register_base_bindings();
		$this->register_base_service_providers();
		$this->register_configured_providers();
	}

	/**
	 * Configure the application
	 *
	 * @return \Vihersalo\Core\Application\ApplicationBuilder
	 */
	public static function configure() {
		return ( new ApplicationBuilder( new static() ) );
	}

	/**
	 * Get the instance of the container
	 *
	 * @return void
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
			HooksLoader::class,
			function () {
				return new HooksLoader();
			}
		);
	}

	/**
	 * Register the base service providers
	 *
	 * @return void
	 */
	protected function register_base_service_providers() {
		$this->register_provider( new DequeueProvider( $this ) );
		$this->register_provider( new EnqueueProvider( $this ) );
		$this->register_provider( new NavigationProvider( $this ) );
		$this->register_provider( new ThemeSupportProvider( $this ) );
		$this->register_provider( new TranslationProvider( $this ) );
		$this->register_provider( new DuplicateProvider( $this ) );
	}

	/**
	 * Register all of the configured providers.
	 *
	 * @return void
	 */
	public function register_configured_providers() {
		$providers = $this->make( 'config' )->get( 'app.providers' );

		foreach ( $providers as $provider ) {
			$this->register_provider( $this->resolve_provider( $provider ) );
		}
	}

		/**
		 * Get the registered service provider instance if it exists.
		 *
		 * @param  \Vihersalo\Core\Support\ServiceProvider|string $provider The provider to get
		 * @return \Vihersalo\Core\Support\ServiceProvider|null
		 */
	public function get_provider( $provider ) {
		$name = is_string( $provider ) ? $provider : get_class( $provider );

		return $this->service_providers[ $name ] ?? null;
	}

	/**
	 * Resolve a service provider instance from the class name.
	 *
	 * @param  string $provider The provider to resolve
	 * @return \Vihersalo\Core\Support\ServiceProvider $provider
	 */
	public function resolve_provider( $provider ) {
		return new $provider( $this );
	}

	/**
	 * Register a service provider with the application.
	 *
	 * @param  Vihersalo\Core\Support\ServiceProvider|string $provider The provider to register
	 * @param  bool                                          $force If true, the provider will be registered even if it has already been registered
	 * @return Vihersalo\Core\Support\ServiceProvider
	 */
	public function register_provider( $provider, $force = false ) {
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

		$this->mark_as_registered( $provider );

		// If the application has already booted, we will call this boot method on
		// the provider class so it has an opportunity to do its boot logic and
		// will be ready for any usage by this developer's application logic.
		if ( $this->is_booted() ) {
			$this->boot_provider( $provider );
		}

		return $provider;
	}

	/**
	 * Register a new registered listener.
	 *
	 * @param  callable $callback The callback to run when a provider is registered
	 * @return void
	 */
	public function registered( $callback ) {
		$this->registered_callbacks[] = $callback;
	}

	/**
	 * Mark the given provider as registered.
	 *
	 * @param  \Vihersalo\Core\Support\ServiceProvider $provider The provider to mark as registered
	 * @return void
	 */
	protected function mark_as_registered( $provider ) {
		$class = get_class( $provider );

		$this->service_providers[ $class ] = $provider;

		$this->loaded_providers[ $class ] = true;
	}

	/**
	 * Call the booting callbacks for the application.
	 *
	 * @param  callable[] $callbacks The callbacks to run
	 * @return void
	 */
	protected function fire_app_callbacks( array &$callbacks ) {
		$index = 0;

		while ( $index < count( $callbacks ) ) {
			$callbacks[ $index ]( $this );

			++$index;
		}
	}

	/**
	 * Determine if the application has booted.
	 *
	 * @return bool
	 */
	public function is_booted() {
		return $this->booted;
	}

	/**
	 * Register a new boot listener.
	 *
	 * @param  callable $callback The callback to run when the application is booting
	 * @return void
	 */
	public function booting( $callback ) {
		$this->booting_callbacks[] = $callback;
	}

	/**
	 * Register a new "booted" listener.
	 *
	 * @param  callable $callback The callback to run when the application has booted
	 * @return void
	 */
	public function booted( $callback ) {
		$this->booted_callbacks[] = $callback;

		if ( $this->is_booted() ) {
			$callback( $this );
		}
	}

	/**
	 * Boot the given service provider.
	 *
	 * @param  \Vihersalo\Core\Support\ServiceProvider $provider The provider to boot
	 * @return void
	 */
	protected function boot_provider( $provider ) {
		$provider->call_booting_callbacks();

		if ( method_exists( $provider, 'boot' ) ) {
			$this->call( [ $provider, 'boot' ] );
		}

		$provider->call_booted_callbacks();
	}

	/**
	 * Boot the application's service providers.
	 *
	 * @return void
	 */
	public function boot() {
		if ( $this->is_booted() ) {
			return;
		}

		// Once the application has booted we will also fire some "booted" callbacks
		// for any listeners that need to do work after this initial booting gets
		// finished. This is useful when ordering the boot-up processes we run.
		$this->fire_app_callbacks( $this->booting_callbacks );

		array_walk(
			$this->service_providers,
			function ( $p ) {
				$this->boot_provider( $p );
			}
		);

		$this->booted = true;

		$this->fire_app_callbacks( $this->booted_callbacks );
	}
}
