<?php

declare(strict_types=1);

namespace Vihersalo\Core\Enqueue;

class AssetCollection {
    /**
     * The assets in the collection.
     * @var array
     */
    protected $assets = [];

    /**
     * Add a asset to the collection.
     * @param Asset $asset
     * @return void
     */
    public function add(Asset $asset) {
        $this->assets[] = $asset;
    }

    /**
     * Get all of the assets in the collection.
     * @return array
     */
    public function get() {
        return $this->assets;
    }
}
