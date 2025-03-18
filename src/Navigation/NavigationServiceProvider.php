<?php 

namespace HeikkiVihersalo\BlockThemeCore\Navigation;

use HeikkiVihersalo\BlockThemeCore\Application;
use HeikkiVihersalo\BlockThemeCore\Loader;
use HeikkiVihersalo\BlockThemeCore\Navigation\NavigationLoader;

use function HeikkiVihersalo\BlockThemeCore\Application\config;

class NavigationServiceProvider {
    /**
     * The application implementation.
     */
    protected $app;

    /**
     * Constructor
     */
    public function __construct(Application $app) {
        $this->app = $app;
    }

    /**
     * Register the navigation provider
     */
    public function register() {
        $this->app->bind(
            NavigationLoader::class,
            fn() => new NavigationLoader(
                $this->app->make(Loader::class),
                config('app.navigation')
            )
        );
    }

    /**
     * Boot the navigation provider
     */
    public function boot() {
    }
}