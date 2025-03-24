<?php

declare(strict_types=1);

namespace Vihersalo\Core\Admin\Duplicate;

use Vihersalo\Core\Admin\Cleanup\Utils;
use Vihersalo\Core\Application\HooksLoader;
use Vihersalo\Core\Support\ServiceProvider;

class AdminCleanupProvider extends ServiceProvider {
    /**
     * Register the navigation provider
     * @return void
     */
    public function register() {
        $this->registerCleanupFunctions($this->app->make(HooksLoader::class));
    }

    /**
     * Enable customizer
     * @param HooksLoader $loader The loader to use
     * @return void
     */
    protected function registerCleanupFunctions(HooksLoader $loader) {
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
