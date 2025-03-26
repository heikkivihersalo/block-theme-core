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
        // Add the route to the collection
        $this->routes[] = $route;

        // We need to pass the route back to the router to allow for chaining
        return $route;
    }

    /**
     * Get all of the routes in the collection.
     * @return array
     */
    public function get() {
        return $this->routes;
    }
}
