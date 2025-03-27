<?php

declare(strict_types=1);

namespace Vihersalo\Core\Support\Facades;

use Vihersalo\Core\Enqueue;

// phpcs:disable
/**
 * @method static \Vihersalo\Core\Enqueue script(string $handle, string $src, string $asset, int $priority = 10, bool $admin = false, bool $editor = false)
 * @method static \Vihersalo\Core\Enqueue style(string $handle, string $src, string $asset, int $priority = 10, bool $admin = false, bool $editor = false)
 * @method static \Vihersalo\Core\Enqueue inline(string $handle, string $path, int $priority = 10)
 *
 * @see Enqueue
 */
class Asset extends Facade {
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor() {
        return 'assets';
    }
}
