<?php

declare(strict_types=1);

namespace Vihersalo\Core\Admin\Settings;

use Vihersalo\Core\Support\Assets\Localize;
use Vihersalo\Core\Support\Collections;

class SettingsMenuBuilder {
    /**
     * Constructor
     * @return void
     */
    public function __construct(protected SettingsMenu $menu) {
    }

    /**
     * Build the submenu from the user callback function
     * @param callable|null $callback The user callback function
     * @return self
     */
    public function withSubmenu(?callable $callback = null) {
        $submenu = new Collections\MenuCollection();

        if (! $callback) {
            return $this;
        }

        $callback($submenu);

        $this->menu->setSubmenu($submenu->get());

        return $this;
    }

    /**
     * Build the assets from the user callback function
     * @param callable|null $callback The user callback function
     * @return self
     */
    public function withAssets(?callable $callback = null) {
        $assets = new Collections\AssetCollection();

        if (! $callback) {
            return $this;
        }

        $callback($assets);

        $this->menu->setAssets($assets->get());

        return $this;
    }

    /**
     * Build the localize from the user callback function
     * @param string $handle The script handle to allow the data to be attached to
     * @param string $objectName The name of the object (this is the name you will use to access the data in JavaScript)
     * @param array  $l10n The data to localize the script with
     * @return self
     */
    public function withLocalize(string $handle, string $objectName, array $l10n) {
        $this->menu->setLocalize(Localize::create($handle, $objectName, $l10n));
        return $this;
    }

    /**
     * Create a new settings menu
     * @return SettingsMenu
     */
    public function create() {
        return $this->menu;
    }
}
