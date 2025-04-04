<?php

declare(strict_types=1);

namespace Vihersalo\Core\Foundation\Bootstrap;

use Exception;
use Vihersalo\Core\Api\Router;
use Vihersalo\Core\Foundation\HooksStore;
use Vihersalo\Core\Support\Collection;
use Vihersalo\Core\Support\Handler;

class ApplicationBuilder {
    /**
     * Application instance
     * @var \Vihersalo\Core\Foundation\Application
     */
    protected $app;

    /**
     * Constructor
     * @param Application $app The application instance.
     * @return void
     */
    public function __construct($app) {
        $this->app = $app;
    }

    /**
     * Build the API for the application instance.
     * @param string $routePath Path to the API route file (e.g. 'routes/api.php')
     * @param string $prefix The API prefix (e.g. 'api/v1')
     * @return self
     */
    public function withApi(string $routePath, string $routeNamespace = 'api/v1') {
        // Register routes to the application
        $this->app->singleton('router', function ($app) use ($routePath, $routeNamespace) {
            return new Router($app, $routePath, $routeNamespace);
        });

        // Register the API routes to hooks loader
        $this->app->make(HooksStore::class)->addAction(
            'rest_api_init',
            $this->app->make('router'),
            'loadRouteFile'
        );

        return $this;
    }

    /**
     * Register the application handlers.
     * @param callable|null $callback The callback to register the handlers.
     * @return self
     */
    public function withHandlers(?callable $callback = null) {
        $handlers = new Collection();

        if (! $callback) {
            return $this;
        }

        $callback($handlers);

        foreach ($handlers->all() as $handler) {
            if (! class_exists($handler)) {
                throw new Exception(
                    sprintf('Handler %s does not exist', $handler)
                );
            }

            $class = new $handler($this->app);

            if (! $class instanceof Handler) {
                throw new Exception(
                    sprintf('Handler %s must extend %s', $handler, Handler::class)
                );
            }

            $class->handle();
        }

        return $this;
    }

    /**
     * Get the application instance.
     * @return \Vihersalo\Core\Foundation\Application
     */
    public function boot() {
        // Boot the application instance
        $this->app->boot();

        // Boot the assets
        $this->app->make('assets')->register();

        // Register the settings menu
        $this->app->make('settings')->register();

        // Boot the hooks loader
        $this->app->make(HooksStore::class)->run();

        return $this->app;
    }
}
