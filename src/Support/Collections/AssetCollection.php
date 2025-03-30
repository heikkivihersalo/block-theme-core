<?php

declare(strict_types=1);

namespace Vihersalo\Core\Support\Collections;

use Vihersalo\Core\Collections\Collection;
use Vihersalo\Core\Enqueue\Asset;

/**
 * @template T of Asset
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
