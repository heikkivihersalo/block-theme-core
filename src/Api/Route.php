<?php

declare(strict_types=1);

namespace Vihersalo\Core\Api;

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
     * The action the route responds to
     * @var array|string|callable|null
     */
    protected $action;

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
    }

    /**
     * Get the methods the route responds to.
     * @return array|string
     */
    public function getMethods() {
        return $this->methods;
    }

    /**
     * Get the URI the route responds to.
     * @return string
     */
    public function getUri() {
        return $this->uri;
    }

    /**
     * Get the action the route responds to.
     * @return array|string|callable|null
     */
    public function getAction() {
        return $this->action;
    }
}
