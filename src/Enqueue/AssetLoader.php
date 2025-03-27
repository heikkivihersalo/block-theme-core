<?php

declare(strict_types=1);

namespace Vihersalo\Core\Enqueue;

use Vihersalo\Core\Foundation\Application;

class AssetLoader {
    /**
     * The application instance.
     * @var Application
     */
    protected $app;

    /**
     * The route collection instance.
     * @var AssetCollection
     */
    protected $assets;

    /**
     * Create a new Enqueue loader instance.
     * @param Application|null  $app
     */
    public function __construct(Application $app) {
        $this->app    = $app;
        $this->assets = new AssetCollection();
    }

    /**
     * Register a new script asset to the collection.
     * @param string $handle The handle of enqueued asset
     * @param string $src The src of enqueued asset
     * @param string $asset The asset file path
     * @param int $priority The priority of the enqueued asset
     * @param bool $admin Whether the asset is for admin or not
     * @param bool $editor Whether the asset is for `add_editor_style` function or not
     * @return Script
     */
    public function script(
        string $handle,
        string $src,
        string $asset,
        int $priority = 10,
        bool $admin = false,
        bool $editor = false
    ) {
        return $this->assets->add(
            Script::create(
                $this->app,
                $handle,
                $src,
                $asset,
                $priority,
                $admin,
                $editor
            )
        );
    }

    /**
     * Register a new style asset to the collection.
     * @param string $handle The handle of enqueued asset
     * @param string $src The src of enqueued asset
     * @param string $asset The asset file path
     * @param int $priority The priority of the enqueued asset
     * @param bool $admin Whether the asset is for admin or not
     * @param bool $editor Whether the asset is for `add_editor_style` function or not
     * @return Style
     */
    public function style(
        string $handle,
        string $src,
        string $asset,
        int $priority = 10,
        bool $admin = false,
        bool $editor = false
    ) {
        return $this->assets->add(
            Style::create(
                $this->app,
                $handle,
                $src,
                $asset,
                $priority,
                $admin,
                $editor
            )
        );
    }

    /**
     * Register a new inline asset to the collection.
     * @param string $handle The handle of enqueued asset
     * @param string $path The URI of enqueued asset file
     * @param int $priority The priority of the enqueued asset
     * @return Inline
     */
    public function inline(string $handle, string $path, int $priority = 10) {
        return $this->assets->add(
            Inline::create(
                $this->app,
                $handle,
                $path,
                $priority
            )
        );
    }

    /**
     * Register the assets to the WordPress hooks
     * @return void
     */
    public function register() {
        require $this->app->make('path') . '/bootstrap/assets.php';

        $assets = $this->assets->get();

        foreach ($assets as $asset) {
            $asset->register();
        }
    }
}
