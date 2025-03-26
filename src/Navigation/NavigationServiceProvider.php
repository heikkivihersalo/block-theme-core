<?php

declare(strict_types=1);

namespace Vihersalo\Core\Navigation;

use Vihersalo\Core\Foundation\WP_Hooks;
use Vihersalo\Core\Support\ServiceProvider;

class NavigationServiceProvider extends ServiceProvider {
    /**
     * Register the navigation provider
     * @return void
     */
    public function register() {
        $this->app->make(WP_Hooks::class)->addAction('init', $this, 'registerNavigationMenus');
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
     * Boot the navigation provider
     * @return void
     */
    public function boot() {
    }
}
