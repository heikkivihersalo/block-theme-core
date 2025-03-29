<?php

declare(strict_types=1);

namespace Vihersalo\Core\Foundation\Providers;

use Vihersalo\Core\Foundation\HooksStore;
use Vihersalo\Core\Support\ServiceProvider;

class ThemeSupportServiceProvider extends ServiceProvider {
    /**
     * Register the navigation provider
     * @return void
     */
    public function register() {
        $store = $this->app->make(HooksStore::class);
        $store->addAction('after_setup_theme', $this, 'addThemeSupports');
        $store->addAction('after_setup_theme', $this, 'removeThemeSupports');
    }

    /**
     * Set theme supports
     * @return   void
     */
    public function addThemeSupports() {
        $features = $this->app->make('config')->get('app.supports');

        foreach ($features as $feature) :
            add_theme_support($feature);
        endforeach;
    }

    /**
     * Remove theme supports
     * @return   void
     */
    public function removeThemeSupports() {
        remove_theme_support('core-block-patterns');
    }

    /**
     * Boot the navigation provider
     */
    public function boot() {
    }
}
