<?php

declare(strict_types=1);

namespace Vihersalo\Core\Enqueue;

use Vihersalo\Core\Collections\Collection;

/**
 * @template T of \Vihersalo\Core\Enqueue\Asset
 * @template-implements \Vihersalo\Core\Contracts\Collections\Collection<T>
 */
class AssetCollection extends Collection {
    /**
     * Constructor
     * @return void
     */
    public function __construct() {
    }
}
