<?php

declare(strict_types=1);

namespace Vihersalo\Core\Admin\Providers;

use Vihersalo\Core\Admin\Cleanup\Utils;
use Vihersalo\Core\Foundation\HooksStore;
use Vihersalo\Core\Support\ServiceProvider;
use Vihersalo\Core\Support\Utils\Common as CommonUtils;

class CleanupServiceProvider extends ServiceProvider {
    /**
     * Register the provider
     * @return void
     */
    public function register() {
        $store = $this->app->make(HooksStore::class);
        $this->registerAdminBar($store);
        $this->registerDashboardMetaboxes($store);
    }

    /**
     * Clean the admin bar
     * @param HooksStore $store The store to use
     * @return void
     */
    protected function registerAdminBar(HooksStore $store) {
        if (! CommonUtils::isLoggedIn()) {
            return;
        }

        $store->addAction('admin_bar_menu', Utils::class, 'removeAdminBarItems');
    }

    /**
     * Clean the dashboard metaboxes
     * @param HooksStore $store The store to use
     * @return void
     */
    protected function registerDashboardMetaboxes(HooksStore $store) {
        if (! CommonUtils::isAdmin()) {
            return;
        }

        $store->addAction('admin_menu', Utils::class, 'setDefaultDashboardMetaboxes');
    }

    /**
     * Boot the provider
     * @return void
     */
    public function boot() {
        // Nothing to do here
    }
}
