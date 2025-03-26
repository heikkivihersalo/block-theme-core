<?php

namespace Vihersalo\Core\Support\Facades;

use Vihersalo\Core\Api\Router;

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
