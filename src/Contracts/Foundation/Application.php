<?php

declare(strict_types=1);

namespace Vihersalo\Core\Contracts\Foundation;

use Illuminate\Contracts\Container\Container;
use Vihersalo\Core\Support\ServiceProvider;

interface Application extends Container {
    /**
     * Configure the real-time facade namespace.
     * @param  string  $namespace
     * @return void
     */
    public function provideFacades(string $namespace);

    /**
     * Get the registered service provider instance if it exists.
     * @param  ServiceProvider|string $provider The provider to get
     * @return ServiceProvider|null
     */
    public function getProvider($provider);

    /**
     * Resolve a service provider instance from the class name.
     * @param  string $provider The provider to resolve
     * @return ServiceProvider $provider
     */
    public function resolveProvider($provider);

    /**
     * Register a service provider with the application.
     * @param  Vihersalo\Core\Support\ServiceProvider|string $provider The provider to register
     * @param  bool $force If true, the provider will be registered even if it has already been registered
     * @return Vihersalo\Core\Support\ServiceProvider
     */
    public function registerProvider($provider, $force = false);

    /**
     * Register a new registered listener.
     * @param  callable $callback The callback to run when a provider is registered
     * @return void
     */
    public function registered($callback);

    /**
     * Call the booting callbacks for the application.
     * @param  callable[] $callbacks The callbacks to run
     * @return void
     */
    public function fireAppCallbacks(array &$callbacks);

    /**
     * Boot the application's service providers.
     *
     * @return void
     */
    public function boot();

    /**
     * Register a new boot listener.
     *
     * @param  callable  $callback
     * @return void
     */
    public function booting($callback);

    /**
     * Register a new "booted" listener.
     *
     * @param  callable  $callback
     * @return void
     */
    public function booted($callback);

    /**
     * Register the core class aliases in the container.
     *
     * @return void
     */
    public function registerCoreContainerAliases();
}
