<?php

declare(strict_types=1);

namespace Vihersalo\Core\Enqueue;

use Vihersalo\Core\Application\HooksLoader;
use Vihersalo\Core\Support\ServiceProvider;

class DequeueProvider extends ServiceProvider {
    /**
     * Register the navigation provider
     * @return void
     */
    public function register() {
        $this->app->make(HooksLoader::class)->addAction(
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
     * Boot the navigation provider
     *
     * @since    1.0.0
     * @access   public
     * @return void
     */
    public function boot() {
    }
}
