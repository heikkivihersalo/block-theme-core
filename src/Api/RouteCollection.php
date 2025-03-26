<?php

declare(strict_types=1);

namespace Vihersalo\Core\Api;

class RouteCollection {
    /**
     * The routes in the collection.
     * @var array
     */
    protected $routes = [];

    /**
     * Add a route to the collection.
     * @param Route $route
     * @return void
     */
    public function add(Route $route) {
        $this->routes[] = $route;
    }

    /**
     * Get all of the routes in the collection.
     * @return array
     */
    public function get() {
        return $this->routes;
    }
}
