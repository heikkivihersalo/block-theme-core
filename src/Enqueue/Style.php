<?php

declare(strict_types=1);

namespace Vihersalo\Core\Enqueue;

use Vihersalo\Core\Foundation\Application;
use Vihersalo\Core\Foundation\HooksStore;

class Style extends Asset {
    /**
     * Create a new style asset
     * @param string $handle The handle of enqueued asset
     * @param string $src The src of enqueued asset
     * @param string $asset The asset file path
     * @param int    $priority The priority of the enqueued asset
     * @param bool   $admin Whether the asset is for admin or not
     * @param bool   $editor Whether the asset is for `add_editor_style` function or not
     * @return self
     */
    public static function create(
        Application $app,
        string $handle,
        string $src,
        string $asset,
        int $priority = 10,
        bool $admin = false,
        bool $editor = false
    ): self {
        return new self($app, $handle, $src, '', $asset, $priority, $admin, $editor);
    }

    /**
     * Enqueue the script
     * @return void
     */
    public function enqueue() {
        $assetPath = $this->getAssetPath();

        if ('' === $assetPath) {
            return;
        }

        $assets = require  $this->app->make('path') . '/' . $assetPath;

        wp_enqueue_style(
            $this->getHandle(),
            $this->app->make('uri') . '/' . $this->getSrc(),
            [],
            $assets['version'],
            'all'
        );
    }

    /**
     * Register the script
     * @return void
     */
    public function register(): void {
        $action = $this->isAdmin() ? 'admin_enqueue_scripts' : 'wp_enqueue_scripts';

        if ($this->isEditor()) {
            $this->loader->add_action('admin_init', $this, 'addToEditorStyles');
        }

        $this->app->make(HooksStore::class)->addAction($action, $this, 'enqueue', $this->getPriority());
    }
}
