<?php

declare(strict_types=1);

namespace Vihersalo\Core\Admin\Providers;

use Vihersalo\Core\Admin\Settings\SettingsMenuManager;
use Vihersalo\Core\Foundation\HooksStore;
use Vihersalo\Core\Support\ServiceProvider;
use Vihersalo\Core\Support\Utils\Common as Utils;

class SettingsMenuServiceProvider extends ServiceProvider {
    /**
     * Register the provider
     * @return void
     */
    public function register() {
        if (! Utils::isAdmin()) {
            return;
        }

        $store = $this->app->make(HooksStore::class);

        $this->registerAdminPages($store);
    }

    /**
     * Register the admin pages
     * @param HooksStore $store The WordPress hooks loader
     * @return void
     */
    public function registerAdminPages(HooksStore $store) {
        $pages = $this->app->make('config')->get('pages');
        $path  = $this->app->make('path');
        $uri   = $this->app->make('uri');

        foreach ($pages as $page) :
            $manager = new SettingsMenuManager($page, $path, $uri);
            $store->addAction('admin_menu', $manager, 'addMenu');
            $store->addAction('admin_enqueue_scripts', $manager, 'enqueueAssets');
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
