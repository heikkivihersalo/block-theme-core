<?php

declare(strict_types=1);

namespace Vihersalo\Core\Contracts\Collections;

/**
 * @template T
 */
interface Collection {
    /**
     * Add new item to the collection. Can be either a single item or an array of items.
     * @param T|T[] $item The item or array of items
     * @return self
     */
    public function add($item);

    /**
     * Get all of the items in the collection.
     * @return T[]
     */
    public function all();

    /**
     * Get the amount if items in the collection
     * @return int
     */
    public function count();
}
