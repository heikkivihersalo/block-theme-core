<?php

declare(strict_types=1);

namespace Vihersalo\Core\Support\Facades;

use Vihersalo\Core\Api;

/**
 * @method static \Vihersalo\Core\Api get(string $uri, array|string|callable|null $action = null)
 * @method static \Vihersalo\Core\Api post(string $uri, array|string|callable|null $action = null)
 * @method static \Vihersalo\Core\Api put(string $uri, array|string|callable|null $action = null)
 * @method static \Vihersalo\Core\Api patch(string $uri, array|string|callable|null $action = null)
 * @method static \Vihersalo\Core\Api delete(string $uri, array|string|callable|null $action = null)
 * @method static \Vihersalo\Core\Api options(string $uri, array|string|callable|null $action = null)
 * @method static \Vihersalo\Core\Api any(string $uri, array|string|callable|null $action = null)
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
