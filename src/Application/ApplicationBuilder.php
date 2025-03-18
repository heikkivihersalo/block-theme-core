<?php

namespace HeikkiVihersalo\BlockThemeCore\Application;

use HeikkiVihersalo\BlockThemeCore\Application;
use HeikkiVihersalo\BlockThemeCore\Loader;

class ApplicationBuilder {
    /**
     * Constructor
     * 
     * @param Application $app
     * @return void
     */
    public function __construct(protected Application $app) {}

    /**
     * Register the providers
     */
    protected function register_providers() {
        $providers = $this->app->make('config')->get('app.providers');

        foreach ($providers as $provider) {
            $provider = new $provider($this->app);
            $provider->register();
        }
    }

    /**
     * Boot the providers
     */
    protected function boot_providers() {
        $providers = $this->app->make('config')->get('app.providers');

        foreach ($providers as $provider) {
            $provider = new $provider($this->app);
            $provider->boot();
        }
    }

    /**
     * Register the WordPress hooks from the loader
     */
    public function wp() {
        $loader = $this->app->make(Loader::class)->run();

        return $this;
    }

    /**
     * Get the application
     * 
     * @return Application
     */
    public function create() {
        $this->register_providers();
        $this->boot_providers();
        
        return $this->app;
    }
}