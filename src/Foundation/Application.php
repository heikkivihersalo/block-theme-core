<?php

declare(strict_types=1);

namespace Vihersalo\Core\Foundation;

use Illuminate\Container\Container;
use Psr\Container\ContainerInterface;
use Vihersalo\Core\Admin\Providers\DuplicateServiceProvider;
use Vihersalo\Core\Admin\Settings\SettingsMenuLoader;
use Vihersalo\Core\Api\Router;
use Vihersalo\Core\Contracts\Foundation\Application as ApplicationContract;
use Vihersalo\Core\Enqueue\AssetLoader;
use Vihersalo\Core\Enqueue\Providers\DequeueServiceProvider;
use Vihersalo\Core\Foundation\Bootstrap\ApplicationBuilder;
use Vihersalo\Core\Foundation\Bootstrap\RegisterFacades;
use Vihersalo\Core\Foundation\Configuration\FileLoader;
use Vihersalo\Core\Foundation\Providers\ThemeSupportServiceProvider;
use Vihersalo\Core\Gutenberg\GutenbergServiceProvider;
use Vihersalo\Core\Navigation\NavigationServiceProvider;
use Vihersalo\Core\PostTypes\PostTypesLoader;
use Vihersalo\Core\PostTypes\PostTypesServiceProvider;
use Vihersalo\Core\Security\SecurityServiceProvider;
use Vihersalo\Core\Support\ServiceProvider;
use Vihersalo\Core\Translations\TranslationServiceProvider;

class Application extends Container implements ApplicationContract {
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
    public function __construct(?string $path = null, ?string $uri = null) {
        if ($path) {
            $this->setBasePath($path);
        }

        if ($uri) {
            $this->setBaseUri($uri);
        }

        // First register the base bindings and paths in the container
        $this->bindPathsInContainer();
        $this->registerBaseBindings();
        $this->registerFacades();
        $this->registerCoreContainerAliases();

        // Register the the service providers
        $this->registerBaseServiceProviders();
        $this->registerConfiguredProviders();
    }

    /**
     * Configure the application
     * @return ApplicationBuilder
     */
    public static function configure(?string $path = null, ?string $uri = null) {
        $basePath = $path ?? get_template_directory();
        $baseUri  = $uri  ?? get_template_directory_uri();

        return (new ApplicationBuilder(new static($basePath, $baseUri)));
    }

    /**
     * Get the instance of the container
     * !NOTE: We need to keep this method protected to avoid conflicts with the container
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

        // Bind the core assets to the container
        $this->app->singleton('assets', function () {
            return new AssetLoader($this);
        });

        // Bind the application settings to the container
        $this->app->singleton('settings', function () {
            return new SettingsMenuLoader($this);
        });

        // Bind the application loader to the container
        $this->singleton(
            HooksStore::class,
            function () {
                return new HooksStore();
            }
        );

        $this->singleton(
            PostTypesLoader::class,
            function () {
                return new PostTypesLoader($this);
            }
        );
    }

    /**
     * Bind all of the application paths in the container.
     *
     * @return void
     */
    protected function bindPathsInContainer() {
        $this->instance('path', $this->basePath);
        $this->instance('uri', $this->baseUri);
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
     * !NOTE: We need to keep this method protected to avoid conflicts with the container
     * @return void
     */
    protected function registerBaseServiceProviders() {
        $this->registerProvider(new DequeueServiceProvider($this));
        $this->registerProvider(new NavigationServiceProvider($this));
        $this->registerProvider(new ThemeSupportServiceProvider($this));
        $this->registerProvider(new SecurityServiceProvider($this));
        $this->registerProvider(new TranslationServiceProvider($this));
        $this->registerProvider(new DuplicateServiceProvider($this));
        $this->registerProvider(new GutenbergServiceProvider($this));
        $this->registerProvider(new PostTypesServiceProvider($this));
    }

    /**
     * Register all of the configured providers.
     * !NOTE: We need to keep this method protected to avoid conflicts with the container
     * @return void
     */
    protected function registerConfiguredProviders() {
        $providers = require $this->basePath . '/bootstrap/providers.php' ?? [];

        foreach ($providers as $provider) {
            $this->registerProvider($this->resolveProvider($provider));
        }
    }

    /**
     * @inheritDoc
     */
    public function getProvider($provider) {
        $name = is_string($provider) ? $provider : get_class($provider);

        return $this->serviceProviders[$name] ?? null;
    }

    /**
     * @inheritDoc
     */
    public function resolveProvider($provider) {
        return new $provider($this);
    }

    /**
     * @inheritDoc
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
     * @inheritDoc
     */
    public function registered($callback) {
        $this->registeredCallbacks[] = $callback;
    }

    /**
     * Mark the given provider as registered.
     * !NOTE: We need to keep this method protected to avoid conflicts with the container
     * @param  ServiceProvider $provider The provider to mark as registered
     * @return void
     */
    protected function markAsRegistered($provider) {
        $class = get_class($provider);

        $this->serviceProviders[$class] = $provider;

        $this->loadedProviders[$class] = true;
    }

    /**
     * @inheritDoc
     */
    public function fireAppCallbacks(array &$callbacks) {
        $index = 0;

        while ($index < count($callbacks)) {
            $callbacks[$index]($this);

            ++$index;
        }
    }

    /**
     * Set the path to the application "app" base directory.
     * @param  string  $path
     * @return void
     */
    public function setBasePath(string $path) {
        $this->basePath = rtrim($path, '\/');
    }

    /**
     * Set the URI to the application "app" base directory.
     * @param  string  $uri
     * @return void
     */
    public function setBaseUri(string $uri) {
        $this->baseUri = rtrim($uri, '\/');
    }

    /**
     * Configure the real-time facade namespace.
     *
     * @param  string  $namespace
     * @return void
     */
    public function provideFacades(string $namespace) {
        AliasLoader::setFacadeNamespace($namespace);
    }

    /**
     * @inheritDoc
     */
    public function isBooted() {
        return $this->booted;
    }

    /**
     * @inheritDoc
     */
    public function booting($callback) {
        $this->bootingCallbacks[] = $callback;
    }

    /**
     * @inheritDoc
     */
    public function booted($callback) {
        $this->bootedCallbacks[] = $callback;

        if ($this->isBooted()) {
            $callback($this);
        }
    }

    /**
     * Boot the given service provider.
     * !NOTE: We need to keep this method protected to avoid conflicts with the container
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
     * @inheritDoc
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
     * @inheritDoc
     */
    public function registerCoreContainerAliases() {
        foreach (
            [
                'app'      => [self::class, ContainerInterface::class],
                'router'   => [Router::class],
                'assets'   => [AssetLoader::class],
                'settings' => [SettingsMenuLoader::class],
            ] as $key => $aliases
        ) {
            foreach ($aliases as $alias) {
                $this->alias($key, $alias);
            }
        }
    }
}
