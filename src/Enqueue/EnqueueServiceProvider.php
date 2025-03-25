<?php

declare(strict_types=1);

namespace Vihersalo\Core\Enqueue;

use Vihersalo\Core\Bootstrap\WP_Hooks;
use Vihersalo\Core\Support\ServiceProvider;
use Vihersalo\Core\Support\Utils\Media as MediaUtils;

class EnqueueServiceProvider extends ServiceProvider {
    /**
     * Register the navigation provider
     * @return void
     */
    public function register() {
        $this->registerAssets();
        $this->registerWpMediaSupport();
    }

    /**
     * Register theme assets
     * @return   void
     */
    public function registerAssets() {
        $assets = $this->app->make('config')->get('app.assets');

        foreach ($assets as $asset) :
            if (method_exists($asset, 'register')) {
                call_user_func([$asset, 'register']);
            }
        endforeach;
    }

    /**
     * Register WP media support
     * @return   void
     */
    public function registerWpMediaSupport() {
        $this->app->make(WP_Hooks::class)->addAction(
            'admin_enqueue_scripts',
            MediaUtils::class,
            'addWpMediaSupport'
        );
    }

    /**
     * Boot the navigation provider
     * @return void
     */
    public function boot() {
    }
}
