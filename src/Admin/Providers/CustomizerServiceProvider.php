<?php

declare(strict_types=1);

namespace Vihersalo\Core\Admin\Providers;

use Vihersalo\Core\Foundation\HooksStore;
use Vihersalo\Core\Support\ServiceProvider;
use Vihersalo\Core\Support\Utils\Common as CommonUtils;

class CustomizerServiceProvider extends ServiceProvider {
    /**
     * Register the provider
     * @return void
     */
    public function register() {
        if (! CommonUtils::isAdmin()) {
            return;
        }

        $store = $this->app->make(HooksStore::class);
        $this->enableCustomizer($store);
    }

    /**
     * Enable customizer
     * @return void
     */
    private function enableCustomizer(HooksStore $store) {
        $store->addAction('customize_register', CommonUtils::class, 'returnTrue');
    }

    /**
     * Boot the provider
     * @return void
     */
    public function boot() {
        // Nothing to do here
    }
}
