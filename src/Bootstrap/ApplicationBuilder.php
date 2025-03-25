<?php

declare(strict_types=1);

namespace Vihersalo\Core\Bootstrap;

class ApplicationBuilder {
    /**
     * Application instance
     * @var Application
     */
    protected Application $app;

    /**
     * Constructor
     * @param Application $app The application instance.
     * @return void
     */
    public function __construct($app) {
        $this->app = $app;
    }

    /**
     * Get the application instance.
     * @return Application
     */
    public function boot() {
        // Boot the application instance
        $this->app->boot();

        // Boot the hooks loader
        $this->app->make(WP_Hooks::class)->run();

        return $this->app;
    }
}
