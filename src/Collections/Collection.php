<?php

declare(strict_types=1);

namespace Vihersalo\Core\Support;

use Vihersalo\Core\Contracts\Collections\Collection as CollectionContract;

/**
 * @template T
 */
class Collection implements CollectionContract {
    /**
     * The items in the collection.
     * @var T[]
     */
    private $items = [];

    /**
     * @inheritDoc
     */
    public function add($item) {
        if (is_array($item)) {
            foreach ($item as $a) {
                $this->item[] = $a;
            }

            return $this;
        }

        $this->items[] = $item;

        return $this;
    }

    /**
     * @inheritDoc
     */
    public function all() {
        return $this->items;
    }

    /**
     * @inheritDoc
     */
    public function count() {
        return count($this->items);
    }
}
