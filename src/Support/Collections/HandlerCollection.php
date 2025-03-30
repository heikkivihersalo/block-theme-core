<?php

declare(strict_types=1);

namespace Vihersalo\Core\Support\Collections;

use Vihersalo\Core\Collections\Collection;

/**
 * @template T of \Vihersalo\Core\Support\Handler
 * @template-implements \Vihersalo\Core\Contracts\Collections\Collection<T>
 */
class HandlerCollection extends Collection {
    /**
     * Constructor
     * @return void
     */
    public function __construct() {
    }
}
