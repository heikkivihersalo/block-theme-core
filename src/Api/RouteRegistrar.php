<?php

declare(strict_types=1);

namespace Vihersalo\Core\Api;

use BackedEnum;
use BadMethodCallException;
use Closure;
use Illuminate\Routing\Route;
use InvalidArgumentException;
use Vihersalo\Core\Support\Reflector;

/**
 * @method \Vihersalo\Core\Api\Route any(string $uri, \Closure|array|string|null $action = null)
 * @method \Vihersalo\Core\Api\Route delete(string $uri, \Closure|array|string|null $action = null)
 * @method \Vihersalo\Core\Api\Route get(string $uri, \Closure|array|string|null $action = null)
 * @method \Vihersalo\Core\Api\Route options(string $uri, \Closure|array|string|null $action = null)
 * @method \Vihersalo\Core\Api\Route patch(string $uri, \Closure|array|string|null $action = null)
 * @method \Vihersalo\Core\Api\Route post(string $uri, \Closure|array|string|null $action = null)
 * @method \Vihersalo\Core\Api\Route put(string $uri, \Closure|array|string|null $action = null)
 * @method \Vihersalo\Core\Api\RouteRegistrar as(string $value)
 * @method \Vihersalo\Core\Api\RouteRegistrar can(\UnitEnum|string  $ability, array|string $models = [])
 * @method \Vihersalo\Core\Api\RouteRegistrar controller(string $controller)
 * @method \Vihersalo\Core\Api\RouteRegistrar domain(\BackedEnum|string $value)
 * @method \Vihersalo\Core\Api\RouteRegistrar middleware(array|string|null $middleware)
 * @method \Vihersalo\Core\Api\RouteRegistrar missing(\Closure $missing)
 * @method \Vihersalo\Core\Api\RouteRegistrar name(\BackedEnum|string $value)
 * @method \Vihersalo\Core\Api\RouteRegistrar namespace(string|null $value)
 * @method \Vihersalo\Core\Api\RouteRegistrar prefix(string $prefix)
 * @method \Vihersalo\Core\Api\RouteRegistrar scopeBindings()
 * @method \Vihersalo\Core\Api\RouteRegistrar where(array $where)
 * @method \Vihersalo\Core\Api\RouteRegistrar withoutMiddleware(array|string $middleware)
 * @method \Vihersalo\Core\Api\RouteRegistrar withoutScopedBindings()
 */
class RouteRegistrar {
    /**
     * The router instance.
     *
     * @var Router
     */
    protected $router;

    /**
     * The attributes to pass on to the router.
     *
     * @var array
     */
    protected $attributes = [];

    /**
     * The methods to dynamically pass through to the router.
     *
     * @var string[]
     */
    protected $passthru = [
        'get',
        'post',
        'put',
        'patch',
        'delete',
        'options',
        'any',
    ];

    /**
     * The attributes that can be set through this class.
     *
     * @var string[]
     */
    protected $allowedAttributes = [
        'controller',
    ];

    /**
     * Create a new route registrar instance.
     *
     * @param  Router  $router
     */
    public function __construct(Router $router) {
        $this->router = $router;
    }

    /**
     * Set the value for a given attribute.
     *
     * @param  string  $key
     * @param  mixed  $value
     * @return $this
     *
     * @throws InvalidArgumentException
     */
    public function attribute($key, $value) {
        if (! in_array($key, $this->allowedAttributes)) {
            throw new InvalidArgumentException("Attribute [{$key}] does not exist.");
        }

        // $attributeKey = Arr::get($this->aliases, $key, $key);

        if ($value instanceof BackedEnum && ! is_string($value = $value->value)) {
            throw new InvalidArgumentException("Attribute [{$key}] expects a string backed enum.");
        }

        $this->attributes[$key] = $value;

        return $this;
    }

    /**
     * Create a route group with shared attributes.
     *
     * @param  Closure|array|string  $callback
     * @return $this
     */
    public function group($callback) {
        $this->router->group($this->attributes, $callback);

        return $this;
    }

    /**
     * Register a new route with the router.
     *
     * @param  string  $method
     * @param  string  $uri
     * @param  Closure|array|string|null  $action
     * @return Route
     */
    protected function registerRoute($method, $uri, $action = null) {
        if (! is_array($action)) {
            $action = array_merge($action ? ['uses' => $action] : []);
        }

        return $this->router->{$method}($uri, $this->compileAction($action));
    }

    /**
     * Compile the action into an array including the attributes.
     *
     * @param  Closure|array|string|null  $action
     * @return array
     */
    protected function compileAction($action) {
        if (null === $action) {
            return []; // No action, return empty array
        }

        if (is_string($action) || $action instanceof Closure) {
            $action = ['uses' => $action];
        }

        if (
            is_array($action) && array_is_list($action) && Reflector::isCallable($action)
        ) {
            if (strncmp($action[0], '\\', 1)) {
                $action[0] = '\\' . $action[0];
            }
            $action = [
                'uses'       => $action[0] . '@' . $action[1],
                'controller' => $action[0] . '@' . $action[1],
            ];
        }

        return $action;
    }

    /**
     * Dynamically handle calls into the route registrar.
     *
     * @param  string  $method
     * @param  array  $parameters
     * @return Route|$this
     *
     * @throws BadMethodCallException
     */
    public function __call($method, $parameters) {
        if (in_array($method, $this->passthru)) {
            return $this->registerRoute($method, ...$parameters);
        }

        if (in_array($method, $this->allowedAttributes)) {
            return $this->attribute($method, array_key_exists(0, $parameters) ? $parameters[0] : true);
        }

        throw new BadMethodCallException(sprintf(
            'Method %s::%s does not exist.',
            static::class,
            $method
        ));
    }
}
