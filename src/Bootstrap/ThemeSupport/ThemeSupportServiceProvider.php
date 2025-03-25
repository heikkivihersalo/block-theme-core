<?php

declare(strict_types=1);

namespace Vihersalo\Core\Bootstrap\ThemeSupport;

use Vihersalo\Core\Bootstrap\WP_Hooks;
use Vihersalo\Core\Support\ServiceProvider;

class ThemeSupportServiceProvider extends ServiceProvider {
    /**
     * Register the navigation provider
     * @return void
     */
    public function register() {
        $this->app->make(WP_Hooks::class)->addAction('after_setup_theme', $this, 'addThemeSupports');
        $this->app->make(WP_Hooks::class)->addAction('after_setup_theme', $this, 'removeThemeSupports');
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
