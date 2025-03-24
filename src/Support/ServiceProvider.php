<?php

declare(strict_types=1);

namespace Vihersalo\Core\Support;

use Closure;
use Vihersalo\Core\Application;

/**
 * The service provider class.
 *
 * @since      1.0.0
 * @package    Vihersalo\Core\Support
 * @author     Heikki Vihersalo <heikki@vihersalo.fi>
 */
abstract class ServiceProvider {
    /**
     * The application instance.
     *
     * @var Application
     */
    protected $app;

    /**
     * All of the registered booting callbacks.
     *
     * @var array
     */
    protected $bootingCallbacks = [];

    /**
     * All of the registered booted callbacks.
     *
     * @var array
     */
    protected $bootedCallbacks = [];

    /**
     * Create a new service provider instance.
     *
     * @param  Application $app The application instance.
     * @return void
     */
    public function __construct($app) {
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
     * @param  Closure $callback The callback to run when the application is booting
     * @return void
     */
    public function booting(Closure $callback) {
        $this->bootingCallbacks[] = $callback;
    }

    /**
     * Register a booted callback to be run after the "boot" method is called.
     *
     * @param  Closure $callback The callback to run when the application has booted
     * @return void
     */
    public function booted(Closure $callback) {
        $this->bootedCallbacks[] = $callback;
    }

    /**
     * Call the registered booting callbacks.
     *
     * @return void
     */
    public function callBootingCallbacks() {
        $index = 0;

        while ($index < count($this->bootingCallbacks)) {
            $this->app->call($this->bootingCallbacks[ $index ]);

            ++$index;
        }
    }

    /**
     * Call the registered booted callbacks.
     *
     * @return void
     */
    public function callBootedCallbacks() {
        $index = 0;

        while ($index < count($this->bootedCallbacks)) {
            $this->app->call($this->bootedCallbacks[ $index ]);

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
    protected function callAfterResolving($name, $callback) {
        $this->app->afterResolving($name, $callback);

        if ($this->app->resolved($name)) {
            $callback($this->app->make($name), $this->app);
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
    public static function defaultProviders() {
        return new DefaultProviders();
    }
}
