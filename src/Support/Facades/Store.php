<?php

declare(strict_types=1);

namespace Vihersalo\Core\Support\Facades;

use Vihersalo\Core\Foundation\HooksStore;

// phpcs:disable
/**
 * @method static \Vihersalo\Core\Foundation\HooksStore addAction(string$hook, object|string|null $component, string $callback, int$priority = 10, int $accepted_args = 1)
 * @method static \Vihersalo\Core\Foundation\HooksStore removeAction(string $hook, callable|string|array $callback, int $priority = 10)
 * @method static \Vihersalo\Core\Foundation\HooksStore addFilter(string $hook, object|string|null $component, string $callback, int $priority = 10, int $accepted_args = 1)
 * @method static \Vihersalo\Core\Foundation\HooksStore removeFilter(string $hook, callable|string|array $callback, int $priority = 10)
 * @see HooksStore
 */
class Store extends Facade {
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor() {
        return HooksStore::class;
    }
}
