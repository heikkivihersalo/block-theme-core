<?php

declare(strict_types=1);

namespace Vihersalo\Core\Enqueue\Providers;

use Vihersalo\Core\Foundation\HooksStore;
use Vihersalo\Core\Support\ServiceProvider;

class DequeueServiceProvider extends ServiceProvider {
    /**
     * Register the provider
     * @return void
     */
    public function register() {
        $this->app->make(HooksStore::class)->addAction(
            'wp_enqueue_scripts',
            $this,
            'dequeueAssets'
        );
    }

    /**
     * Register theme assets
     * @return   void
     */
    public function dequeueAssets() {
        $dequeue = $this->app->make('config')->get('app.dequeue');

        foreach ($dequeue as $asset) :
            if (! is_string($asset)) {
                continue;
            }

            wp_deregister_style($asset);
            wp_dequeue_style($asset);
        endforeach;
    }

    /**
     * Boot the provider
     * @return void
     */
    public function boot() {
        // Nothing to do here
    }
}
