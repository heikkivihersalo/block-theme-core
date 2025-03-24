<?php

declare(strict_types=1);

namespace Vihersalo\Core\Support\Collections;

use Vihersalo\Core\Enqueue\Asset;

class AssetCollection {
    /**
     * Array of assets to be enqueued in the theme
     * @var array $assets The assets
     */
    private $assets = [];

    /**
     * Constructor
     * @return void
     */
    public function __construct() {
    }

    /**
     * Add new asset to the collection. Can be either a single asset or an array of assets.
     * @param Asset|array $asset The asset or array of assets
     * @return self
     */
    public function add($asset) {
        if (is_array($asset)) {
            foreach ($asset as $a) {
                if ($a instanceof Asset) {
                    $this->assets[] = $a;
                }
            }

            return $this;
        }

        if ($asset instanceof Asset) {
            $this->assets[] = $asset;
        }

        return $this;
    }

    /**
     * Get the assets
     *
     * @return array The assets
     */
    public function get(): array {
        return $this->assets;
    }
}
