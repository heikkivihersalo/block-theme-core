<?php

declare(strict_types=1);

namespace Vihersalo\Core\Bootstrap;

use Illuminate\Container\Container;
use Psr\Container\ContainerInterface;
use Vihersalo\Core\Admin\Duplicate\DuplicateServiceProvider;
use Vihersalo\Core\Api\Router;
use Vihersalo\Core\Bootstrap\ThemeSupport\ThemeSupportServiceProvider;
use Vihersalo\Core\Configuration\FileLoader;
use Vihersalo\Core\Enqueue\DequeueServiceProvider;
use Vihersalo\Core\Enqueue\EnqueueServiceProvider;
use Vihersalo\Core\Navigation\NavigationServiceProvider;
use Vihersalo\Core\Support\ServiceProvider;
use Vihersalo\Core\Translations\TranslationServiceProvider;

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
    protected $basePath;

    /**
     * The URI to the application "app" base directory.
     * @var string
     */
    protected $baseUri;

    /**
     * Indicates if the application has "booted".
     * @var bool
     */
    protected $booted = false;

    /**
     * The array of registered callbacks.
     * @var callable[]
     */
    protected $registeredCallbacks = [];

    /**
     * The array of booting callbacks.
     * @var callable[]
     */
    protected $bootingCallbacks = [];

    /**
     * The array of booted callbacks.
     * @var callable[]
     */
    protected $bootedCallbacks = [];

    /**
     * All of the registered service providers.
     * @var array<string, \Vihersalo\Core\Support\ServiceProvider
     */
    protected $serviceProviders = [];

    /**
     * The names of the loaded service providers.
     * @var array
     */
    protected $loadedProviders = [];

    /**
     * Constructor
     * @param string $basePath The path to the application "app" base directory
     * @param string $baseUri The URI to the application "app" base directory
     * @return void
     */
    public function __construct($basePath = null, $baseUri = null) {
        $this->basePath = $basePath ?? get_template_directory();
        $this->baseUri  = $baseUri  ?? get_template_directory_uri();

        $this->registerBaseBindings();
        $this->registerBaseServiceProviders();
        $this->registerConfiguredProviders();
        $this->registerFacades();
        $this->registerCoreContainerAliases();
    }

    /**
     * Configure the application
     * @return ApplicationBuilder
     */
    public static function configure() {
        return (new ApplicationBuilder(new static()));
    }

    /**
     * Get the instance of the container
     * @return void
     */
    protected function registerBaseBindings() {
        static::$container = static::setInstance($this);

        $this->instance('app', $this);
        $this->instance(Container::class, $this);

        // Bind the application config files to the container
        $this->singleton(
            'config',
            function () {
                return new FileLoader($this->basePath . '/config');
            }
        );

        // Bind the application loader to the container
        $this->singleton(
            WP_Hooks::class,
            function () {
                return new WP_Hooks();
            }
        );
    }

    /**
     * Register the facades for the application
     * @return void
     */
    protected function registerFacades() {
        (new RegisterFacades())->bootstrap($this);
    }

    /**
     * Register the base service providers
     * @return void
     */
    protected function registerBaseServiceProviders() {
        $this->registerProvider(new DequeueServiceProvider($this));
        $this->registerProvider(new EnqueueServiceProvider($this));
        $this->registerProvider(new NavigationServiceProvider($this));
        $this->registerProvider(new ThemeSupportServiceProvider($this));
        $this->registerProvider(new TranslationServiceProvider($this));
        $this->registerProvider(new DuplicateServiceProvider($this));
    }

    /**
     * Configure the real-time facade namespace.
     *
     * @param  string  $namespace
     * @return void
     */
    public function provideFacades($namespace) {
        AliasLoader::setFacadeNamespace($namespace);
    }

    /**
     * Register all of the configured providers.
     * @return void
     */
    public function registerConfiguredProviders() {
        $providers = require $this->basePath . '/bootstrap/providers.php' ?? [];

        foreach ($providers as $provider) {
            $this->registerProvider($this->resolveProvider($provider));
        }
    }

    /**
     * Get the registered service provider instance if it exists.
     * @param  ServiceProvider|string $provider The provider to get
     * @return ServiceProvider|null
     */
    public function getProvider($provider) {
        $name = is_string($provider) ? $provider : get_class($provider);

        return $this->serviceProviders[$name] ?? null;
    }

    /**
     * Resolve a service provider instance from the class name.
     * @param  string $provider The provider to resolve
     * @return ServiceProvider $provider
     */
    public function resolveProvider($provider) {
        return new $provider($this);
    }

    /**
     * Register a service provider with the application.
     * @param  Vihersalo\Core\Support\ServiceProvider|string $provider The provider to register
     * @param  bool $force If true, the provider will be registered even if it has already been registered
     * @return Vihersalo\Core\Support\ServiceProvider
     */
    public function registerProvider($provider, $force = false) {
        if (($registered = $this->getProvider($provider)) && ! $force) {
            return $registered;
        }

        // If the given "provider" is a string, we will resolve it, passing in the
        // application instance automatically for the developer. This is simply
        // a more convenient way of specifying your service provider classes.
        if (is_string($provider)) {
            $provider = $this->resolveProvider($provider);
        }

        $provider->register();

        // If there are bindings / singletons set as properties on the provider we
        // will spin through them and register them with the application, which
        // serves as a convenience layer while registering a lot of bindings.
        if (property_exists($provider, 'bindings')) {
            foreach ($provider->bindings as $key => $value) {
                $this->bind($key, $value);
            }
        }

        if (property_exists($provider, 'singletons')) {
            foreach ($provider->singletons as $key => $value) {
                $key = is_int($key) ? $value : $key;

                $this->singleton($key, $value);
            }
        }

        $this->markAsRegistered($provider);

        // If the application has already booted, we will call this boot method on
        // the provider class so it has an opportunity to do its boot logic and
        // will be ready for any usage by this developer's application logic.
        if ($this->isBooted()) {
            $this->bootProvider($provider);
        }

        return $provider;
    }

    /**
     * Register a new registered listener.
     * @param  callable $callback The callback to run when a provider is registered
     * @return void
     */
    public function registered($callback) {
        $this->registeredCallbacks[] = $callback;
    }

    /**
     * Mark the given provider as registered.
     * @param  ServiceProvider $provider The provider to mark as registered
     * @return void
     */
    protected function markAsRegistered($provider) {
        $class = get_class($provider);

        $this->serviceProviders[$class] = $provider;

        $this->loadedProviders[$class] = true;
    }

    /**
     * Call the booting callbacks for the application.
     * @param  callable[] $callbacks The callbacks to run
     * @return void
     */
    protected function fireAppCallbacks(array &$callbacks) {
        $index = 0;

        while ($index < count($callbacks)) {
            $callbacks[$index]($this);

            ++$index;
        }
    }

    /**
     * Determine if the application has booted.
     * @return bool
     */
    public function isBooted() {
        return $this->booted;
    }

    /**
     * Register a new boot listener.
     * @param  callable $callback The callback to run when the application is booting
     * @return void
     */
    public function booting($callback) {
        $this->bootingCallbacks[] = $callback;
    }

    /**
     * Register a new "booted" listener.
     * @param  callable $callback The callback to run when the application has booted
     * @return void
     */
    public function booted($callback) {
        $this->bootedCallbacks[] = $callback;

        if ($this->isBooted()) {
            $callback($this);
        }
    }

    /**
     * Boot the given service provider.
     * @param  ServiceProvider $provider The provider to boot
     * @return void
     */
    protected function bootProvider($provider) {
        $provider->callBootingCallbacks();

        if (method_exists($provider, 'boot')) {
            $this->call([$provider, 'boot']);
        }

        $provider->callBootedCallbacks();
    }

    /**
     * Boot the application's service providers.
     * @return void
     */
    public function boot() {
        if ($this->isBooted()) {
            return;
        }

        // Once the application has booted we will also fire some "booted" callbacks
        // for any listeners that need to do work after this initial booting gets
        // finished. This is useful when ordering the boot-up processes we run.
        $this->fireAppCallbacks($this->bootingCallbacks);

        array_walk(
            $this->serviceProviders,
            function ($p) {
                $this->bootProvider($p);
            }
        );

        $this->booted = true;

        $this->fireAppCallbacks($this->bootedCallbacks);
    }

    /**
     * Register the core class aliases in the container.
     *
     * @return void
     */
    public function registerCoreContainerAliases() {
        foreach (
            [
                'app'    => [self::class, ContainerInterface::class],
                'router' => [Router::class],
            ] as $key => $aliases
        ) {
            foreach ($aliases as $alias) {
                $this->alias($key, $alias);
            }
        }
    }
}
