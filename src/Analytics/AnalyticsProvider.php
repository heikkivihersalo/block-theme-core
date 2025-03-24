<?php

declare(strict_types=1);

namespace Vihersalo\Core\Analytics;

use Vihersalo\Core\Application\HooksLoader;
use Vihersalo\Core\Support\ServiceProvider;

class AnalyticsProvider extends ServiceProvider {
    /**
     * Register the navigation provider
     * @return void
     */
    public function register() {
        $this->registerTagmanager();
    }

    /**
     * Register the Google Tag Manager
     * @return void
     */
    public function registerTagmanager() {
        $tagmanager = new TagManager();

        $this->app->make(HooksLoader::class)->addAction('wp_head', $tagmanager, 'inlineTagManager', 0);
    }

    /**
     * Boot the navigation provider
     */
    public function boot() {
    }
}
