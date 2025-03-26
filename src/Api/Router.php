<?php

declare(strict_types=1);

namespace Vihersalo\Core\Api;

use Closure;
use Vihersalo\Core\Bootstrap\Application;

class Router {
    /**
     * The application instance.
     * @var Application
     */
    protected $app;

    /**
     * Route path
     * @var string
     */
    protected $routePath;

    /**
     * Route namespace
     * @var string
     */
    protected $routeNamespace;

    /**
     * The route collection instance.
     * @var RouteCollection
     */
    protected $routes;

    /**
     * All of the verbs supported by the router.
     *
     * @var string[]
     */
    public static $verbs = ['GET', 'HEAD', 'POST', 'PUT', 'PATCH', 'DELETE', 'OPTIONS'];

    /**
     * Create a new Router instance.
     * @param Application|null  $app
     * @param string                                      $routePath
     * @param string                                      $routeNamespace
     */
    public function __construct(Application $app, string $routePath, string $routeNamespace) {
        $this->app            = $app;
        $this->routePath      = $routePath;
        $this->routeNamespace = $routeNamespace;

        $this->routes = new RouteCollection();
    }

    /**
     * Register a new GET route with the router.
     *
     * @param  string  $uri
     * @param  array|string|callable|null  $action
     * @return Route
     */
    public function get($uri, $action = null) {
        return $this->addRoute(['GET', 'HEAD'], $uri, $action);
    }

    /**
     * Register a new POST route with the router.
     *
     * @param  string  $uri
     * @param  array|string|callable|null  $action
     * @return Route
     */
    public function post($uri, $action = null) {
        return $this->addRoute('POST', $uri, $action);
    }

    /**
     * Register a new PUT route with the router.
     *
     * @param  string  $uri
     * @param  array|string|callable|null  $action
     * @return Route
     */
    public function put($uri, $action = null) {
        return $this->addRoute('PUT', $uri, $action);
    }

    /**
     * Register a new PATCH route with the router.
     *
     * @param  string  $uri
     * @param  array|string|callable|null  $action
     * @return Route
     */
    public function patch($uri, $action = null) {
        return $this->addRoute('PATCH', $uri, $action);
    }

    /**
     * Register a new DELETE route with the router.
     *
     * @param  string  $uri
     * @param  array|string|callable|null  $action
     * @return Route
     */
    public function delete($uri, $action = null) {
        return $this->addRoute('DELETE', $uri, $action);
    }

    /**
     * Register a new OPTIONS route with the router.
     *
     * @param  string  $uri
     * @param  array|string|callable|null  $action
     * @return Route
     */
    public function options($uri, $action = null) {
        return $this->addRoute('OPTIONS', $uri, $action);
    }

    /**
     * Register a new route responding to all verbs.
     *
     * @param  string  $uri
     * @param  array|string|callable|null  $action
     * @return Route
     */
    public function any($uri, $action = null) {
        return $this->addRoute(self::$verbs, $uri, $action);
    }

    /**
     * Add a route to the underlying route collection.
     *
     * @param  array|string  $methods
     * @param  string  $uri
     * @param  array|string|callable|null  $action
     * @return Route
     */
    public function addRoute($methods, $uri, $action) {
        return $this->routes->add($this->createRoute($methods, $uri, $action));
    }

    /**
     * Create a new route instance.
     *
     * @param  array|string  $methods
     * @param  string  $uri
     * @param  mixed  $action
     * @return Route
     */
    protected function createRoute($methods, $uri, $action) {
        return new Route($methods, $uri, $action);
    }

    /**
     * Get the underlying route collection.
     * @return RouteCollection
     */
    public function getRoutes() {
        return $this->routes;
    }

    /**
     * Resolve the permission callback for a route.
     *
     * @param  Route  $route
     * @return Closure|bool
     */
    public function resolvePermissionCallback(Route $route) {
        $auth = $route->getAuthPermission();

        if ($auth === null) {
            return true;
        }

        return $auth->callback();
    }

    /**
     * Register the routes in the collection.
     * @return void
     */
    public function registerRoutes() {
        require $this->routePath;

        $routes = $this->routes->get();

        foreach ($routes as $route) {
            register_rest_route(
                $this->routeNamespace,
                $route->uri(),
                [
                    'methods'             => $route->methods(),
                    'callback'            => [$route->resolveClass(), $route->resolveMethod()],
                    'permission_callback' => $this->resolvePermissionCallback($route)
                ]
            );
        }
    }
}
