<?php

declare(strict_types=1);

namespace Vihersalo\Core\Admin\Duplicate;

use Vihersalo\Core\Admin\Cleanup\Utils;
use Vihersalo\Core\Bootstrap\WP_Hooks;
use Vihersalo\Core\Support\ServiceProvider;

class AdminCleanupServiceProvider extends ServiceProvider {
    /**
     * Register the navigation provider
     * @return void
     */
    public function register() {
        $this->registerCleanupFunctions($this->app->make(WP_Hooks::class));
    }

    /**
     * Enable customizer
     * @param WP_Hooks $loader The loader to use
     * @return void
     */
    protected function registerCleanupFunctions(WP_Hooks $loader) {
        $loader->addAction('admin_bar_menu', Utils::class, 'removeAdminBarItems');
        $loader->addAction('admin_menu', Utils::class, 'setDefaultDashboardMetaboxes');
    }

    /**
     * Boot the navigation provider
     * @return void
     */
    public function boot() {
    }
}
