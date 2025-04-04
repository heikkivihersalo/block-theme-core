<?php

declare(strict_types=1);

namespace Vihersalo\Core\Enqueue;

use Vihersalo\Core\Foundation\Application;
use Vihersalo\Core\Foundation\HooksStore;

class Script extends Asset {
    /**
     * Create a new script asset instance
     * @param Application $app The application instance
     * @param string $handle The handle of enqueued asset
     * @param string $src The URI of enqueued asset
     * @param string|array $asset The asset file path
     * @param int    $priority The priority of the enqueued asset
     * @param bool   $admin Whether the asset is for admin or not
     * @return self
     */
    public static function create(
        Application $app,
        string $handle,
        string $src,
        string|array $asset,
        int $priority = 10,
        bool $admin = false
    ): self {
        return new self($app, $handle, $src, '', $asset, $priority, $admin);
    }

    /**
     * Enqueue the script
     * @return void
     */
    public function enqueue() {
        $assets = $this->resolveAsset();

        if (! $assets) {
            return;
        }

        wp_enqueue_script(
            $this->getHandle(),
            $this->app->make('uri') . '/' . $this->getSrc(),
            $assets['dependencies'],
            $assets['version'],
            true
        );
    }

    /**
     * Register the script
     * @return void
     */
    public function register(): void {
        $action = $this->isAdmin() ? 'admin_enqueue_scripts' : 'wp_enqueue_scripts';
        $this->app->make(HooksStore::class)->addAction($action, $this, 'enqueue', $this->getPriority());
    }
}
