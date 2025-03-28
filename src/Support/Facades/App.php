<?php

namespace Vihersalo\Core\Support\Facades;

class App extends Facade {
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor() {
        return 'app';
    }
}
