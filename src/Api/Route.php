<?php

declare(strict_types=1);

namespace Vihersalo\Core\Api;

use Vihersalo\Core\Contracts\Enums\Permission;
use Vihersalo\Core\Support\Utils\Common as CommonUtils;

class Route {
    /**
     * The methods the route responds to
     * @var array|string
     */
    protected $methods;

    /**
     * The URI the route responds to
     * @var string
     */
    protected $uri;

    /**
     * The controller instance.
     *
     * @var mixed
     */
    public $controller;

    /**
     * The action the route responds to
     * @var array|string|callable|null
     */
    protected $action;

    /**
     * The permission the route responds to
     * @var Permission|null
     */
    protected $auth;

    /**
     * Create a new route instance.
     * @param  array|string                $methods
     * @param  string                      $uri
     * @param  array|string|callable|null  $action
     * @return void
     */
    public function __construct($methods, $uri, $action) {
        $this->methods = $methods;
        $this->uri     = $uri;
        $this->action  = $action;

        $this->auth = null;
    }

    public function getAuthPermission() {
        return $this->auth;
    }

    /**
     * Get the methods the route responds to.
     * @return array|string
     */
    public function methods() {
        return $this->methods;
    }

    /**
     * Get the URI the route responds to.
     * @return string
     */
    public function uri() {
        return $this->uri;
    }

    /**
     * Get the class the route responds to.
     * @return object|null
     */
    public function resolveClass() {
        $action = $this->action;

        if (is_array($action)) {
            if (! class_exists($action[0])) {
                return null;
            }

            return new $action[0]();
        }

        return null;
    }

    /**
     * Get the method the route responds to.
     * @return string|null
     */
    public function resolveMethod() {
        return $this->action ?? null;
    }

    /**
     * Set the permission the route
     * @return Route
     */
    public function auth(?Permission $auth = null) {
        // If user enables auth and does not set permission level, set the permission to ADMIN by default
        // This is security enforcement to make sure that there is no accidental public routes that
        // should be private or vice versa
        if ($auth === null) {
            $this->auth = fn () => CommonUtils::isUserAdmin();
        } else {
            $this->auth = $auth; // If user sets permission level, use that instead
        }

        // For chaining purposes we need to return the route
        return $this;
    }
}
