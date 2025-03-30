<?php

declare(strict_types=1);

namespace Vihersalo\Core\Admin\Settings;

use Vihersalo\Core\Foundation\HooksStore;
use Vihersalo\Core\Foundation\Application;

class SettingsMenuLoader {
    /**
     * The application instance.
     * @var Application
     */
    protected $app;

    /**
     * The route collection instance.
     * @var SettingsMenuCollection
     */
    protected $settingsMenus;

    /**
     * Create a new Enqueue loader instance.
     * @param Application|null  $app
     */
    public function __construct(Application $app) {
        $this->app    = $app;
        $this->settingsMenus = new SettingsMenuCollection();
    }

    /**
     * Register a new settings menu to the collection.
     * @param string $slug The slug of the menu
     * @param string $pageTitle The title of the page
     * @param string $menuTitle The title of the menu
     * @param string $path The callback function path
     * @param string $capability The capability required to view the page
     * @param string $icon The icon of the menu
     * @param int $position The position of the menu
     * @return \Vihersalo\Core\Admin\Settings\SettingsMenu
     */
    public function create(string $slug, string $pageTitle, string $menuTitle, string $path, string $capability, string $icon, int $position) {
        // First create the menu
        $menu = SettingsMenu::create(
            $slug,
            $pageTitle,
            $menuTitle,
            $path,
            $capability,
            $icon,
            $position
        );

        // Add to the collection
        $this->settingsMenus->add($menu);

        // Return menu for method chaining
        return $menu;
    }

    /**
     * Register the assets to the WordPress hooks
     * @return void
     */
    public function register() {
        $menus = $this->settingsMenus->all();
        $store = $this->app->make(HooksStore::class);
        $path  = $this->app->make('path');
        $uri   = $this->app->make('uri');

        foreach ($menus as $menu) {
            $manager = new SettingsMenuManager($menu, $path, $uri);
            $store->addAction('admin_menu', $manager, 'addMenu');
            $store->addAction('admin_enqueue_scripts', $manager, 'enqueueAssets');
        }
    }
}
