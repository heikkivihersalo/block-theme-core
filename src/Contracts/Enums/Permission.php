<?php

declare(strict_types=1);

namespace Vihersalo\Core\Contracts\Enums;

use Closure;

interface Permission {
    /**
     * Get the callback for the permission.
     * @return Closure|bool
     */
    public function callback(): Closure|bool;
}
