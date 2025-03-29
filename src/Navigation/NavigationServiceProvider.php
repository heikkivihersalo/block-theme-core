<?php

declare(strict_types=1);

namespace Vihersalo\Core\Navigation;

use Vihersalo\Core\Foundation\HooksStore;
use Vihersalo\Core\Support\ServiceProvider;

class NavigationServiceProvider extends ServiceProvider {
    /**
     * Register the provider
     * @return void
     */
    public function register() {
        $this->app->make(HooksStore::class)->addAction('init', $this, 'registerNavigationMenus');
    }

    /**
     * Load navigation menus
     * @return void
     */
    public function registerNavigationMenus(): void {
        $locations = $this->app->make('config')->get('app.navigation');

        foreach ($locations as $menu) :
            register_nav_menu($menu->getSlug(), $menu->getName());
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
