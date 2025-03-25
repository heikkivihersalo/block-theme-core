<?php

declare(strict_types=1);

namespace Vihersalo\Core\Configuration;

use Vihersalo\Core\Application\HooksLoader;
use Vihersalo\Core\Support\ServiceProvider;

class ThemeSupportServiceProvider extends ServiceProvider {
    /**
     * Register the navigation provider
     * @return void
     */
    public function register() {
        $this->app->make(HooksLoader::class)->addAction('after_setup_theme', $this, 'addThemeSupports');
        $this->app->make(HooksLoader::class)->addAction('after_setup_theme', $this, 'removeThemeSupports');
    }

    /**
     * Set theme supports
     *
     * @since    1.0.0
     * @access   public
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
     *
     * @since    1.0.0
     * @access   public
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
