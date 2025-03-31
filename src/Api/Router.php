<?php

declare(strict_types=1);

namespace Vihersalo\Core\Api;

use Closure;
use Exception;
use Vihersalo\Core\Collections\Arr;
use Vihersalo\Core\Contracts\Enums\Permission;
use Vihersalo\Core\Foundation\Application;

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
     * The route group attribute stack.
     *
     * @var array
     */
    protected $groupAttributeStack = [];

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
     * Create a route group with shared attributes.
     *
     * @param  array  $attributes
     * @param  Closure|array|string  $routes
     * @return $this
     */
    public function group(array $attributes, $routes) {
        foreach (Arr::wrap($routes) as $groupRoutes) {
            $this->updateGroupAttributeStack($attributes);

            // Once we have updated the group stack, we'll load the provided routes and
            // merge in the group's attributes when the routes are created. After we
            // have created the routes, we will pop the attributes off the stack.
            $this->loadRoutes($groupRoutes);

            array_pop($this->groupAttributeStack);
        }

        return $this;
    }

    /**
     * Update the group stack with the given attributes.
     *
     * @param  array  $attributes
     * @return void
     */
    protected function updateGroupAttributeStack(array $attributes) {
        // if ($this->hasGroupAttributeStack()) {
        //     $attributes = $this->mergeWithLastGroup($attributes);
        // }

        $this->groupAttributeStack[] = $attributes;
    }

    /**
     * Determine if the router currently has a group stack.
     *
     * @return bool
     */
    public function hasGroupAttributeStack() {
        return ! empty($this->groupAttributeStack);
    }

    /**
     * Get the current group stack for the router.
     *
     * @return array
     */
    public function getGroupAttributeStack() {
        return $this->groupAttributeStack;
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

        // If no auth is set, return true
        if ($auth === null) {
            return fn () => true;
        }

        // Auth must implement the Permission interface
        if (! $auth instanceof Permission) {
            throw new Exception(
                sprintf('Auth must implement %s', Permission::class)
            );
        }

        // If auth is set, return the user defined callback
        return $auth->callback();
    }

    public function resolveGroupController() {
        $groupAttributes = $this->getGroupAttributeStack();

        if (empty($groupAttributes)) {
            return null;
        }

        $groupAttributes = array_reverse($groupAttributes);

        foreach ($groupAttributes as $attributes) {
            if (array_key_exists('controller', $attributes)) {
                return new $attributes['controller']();
            }
        }

        return null;
    }

    /**
     * Register the routes in the collection.
     * @return void
     */
    public function registerRestRoutes() {
        $routes = $this->routes->get();

        foreach ($routes as $route) {
            register_rest_route(
                $this->routeNamespace,
                $route->uri(),
                [
                    'methods'             => $route->methods(),
                    'callback'            => [$this->resolveGroupController(), $route->resolveMethod()],
                    'permission_callback' => $this->resolvePermissionCallback($route)
                ]
            );
        }
    }


    /**
     * Load the route file.
     *
     * @return void
     * @throws Exception
     */
    public function loadRouteFile() {
        $this->loadRoutes($this->routePath);
    }

    /**
     * Load the provided routes.
     *
     * @param  Closure|string  $routes
     * @return void
     */
    protected function loadRoutes($routes) {
        if ($routes instanceof Closure) {
            // This will load the routes from the closure
            $routes($this);

            // Then we can register the routes to the WP REST API
            $this->registerRestRoutes();
        } else {
            (new RouteFileRegistrar($this))->register($routes);
        }
    }

    /**
     * Dynamically handle calls into the router instance.
     *
     * @param  string  $method
     * @param  array  $parameters
     * @return mixed
     */
    public function __call($method, $parameters) {
        return (
            new RouteRegistrar($this)
            )->attribute($method, array_key_exists(0, $parameters) ? $parameters[0] : true);
    }
}
