<?php

declare(strict_types=1);

namespace Vihersalo\Core\Admin\Settings\Providers;

use Vihersalo\Core\Admin\Settings\SettingsMenuManager;
use Vihersalo\Core\Bootstrap\WP_Hooks;
use Vihersalo\Core\Support\ServiceProvider;
use Vihersalo\Core\Support\Utils\Common as Utils;

class SettingsMenuServiceProvider extends ServiceProvider {
    /**
     * Register the navigation provider
     */
    public function register() {
        if (! Utils::isAdmin()) {
            return;
        }

        $this->registerAdminPages($this->app->make(WP_Hooks::class));
    }

    public function registerAdminPages(WP_Hooks $loader) {
        $pages = $this->app->make('config')->get('pages');
        $path  = $this->app->make('config')->get('app.path');
        $uri   = $this->app->make('config')->get('app.uri');

        foreach ($pages as $page) :
            $manager = new SettingsMenuManager($page, $path, $uri);
            $loader->addAction('admin_menu', $manager, 'addMenu');
            $loader->addAction('admin_enqueue_scripts', $manager, 'enqueueAssets');
        endforeach;
    }
}
