<?php

declare(strict_types=1);

namespace Vihersalo\Core\Support\Facades;

use Vihersalo\Core\Api;

/**
 * @method static \Vihersalo\Core\Api\Route get(string $uri, array|string|callable|null $action = null)
 * @method static \Vihersalo\Core\Api\Route post(string $uri, array|string|callable|null $action = null)
 * @method static \Vihersalo\Core\Api\Route put(string $uri, array|string|callable|null $action = null)
 * @method static \Vihersalo\Core\Api\Route patch(string $uri, array|string|callable|null $action = null)
 * @method static \Vihersalo\Core\Api\Route delete(string $uri, array|string|callable|null $action = null)
 * @method static \Vihersalo\Core\Api\Route options(string $uri, array|string|callable|null $action = null)
 * @method static \Vihersalo\Core\Api\Route any(string $uri, array|string|callable|null $action = null)
 * @method static \Vihersalo\Core\Api\Router group(array $attributes, \Closure|array|string $routes)
 * @method static \Vihersalo\Core\Api\RouteRegistrar controller(string $controller)
 *
 * @see Api
 */
class Route extends Facade {
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor() {
        return 'router';
    }
}
