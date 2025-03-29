<?php

declare(strict_types=1);

namespace Vihersalo\Core\Analytics;

use Vihersalo\Core\Foundation\HooksStore;
use Vihersalo\Core\Support\ServiceProvider;

class AnalyticsServiceProvider extends ServiceProvider {
    /**
     * Register the provider
     * @return void
     */
    public function register() {
        $store = $this->app->make(HooksStore::class);
        $this->registerTagmanager($store);
    }

    /**
     * Register the Google Tag Manager
     * @param HooksStore $store The WordPress hooks loader
     * @return void
     */
    public function registerTagmanager(HooksStore $store) {
        $tagmanager = new TagManager();
        $store->addAction('wp_head', $tagmanager, 'inlineTagManager', 0);
    }

    /**
     * Boot the provider
     * @return void
     */
    public function boot() {
        // Nothing to do here
    }
}
