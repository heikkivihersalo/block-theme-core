<?php

declare(strict_types=1);

namespace Vihersalo\Core\Api;

class RouteFileRegistrar {
    /**
     * The router instance.
     *
     * @var Router
     */
    protected $router;

    /**
     * Create a new route file registrar instance.
     *
     * @param  Router  $router
     */
    public function __construct(Router $router) {
        $this->router = $router;
    }

    /**
     * Require the given routes file.
     *
     * @param  string  $routes
     * @return void
     */
    public function register($routes) {
        $router = $this->router;

        require $routes;
    }
}
