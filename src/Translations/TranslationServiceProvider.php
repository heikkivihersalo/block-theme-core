<?php

declare(strict_types=1);

namespace Vihersalo\Core\Translations;

use Vihersalo\Core\Foundation\HooksStore;
use Vihersalo\Core\Support\ServiceProvider;

class TranslationServiceProvider extends ServiceProvider {
    /**
     * Register the provider
     * @return void
     */
    public function register() {
        $this->app->make(HooksStore::class)->addAction('after_setup_theme', $this, 'loadTextdomain');
    }

    /**
     * Load navigation menus
     * @return void
     */
    public function loadTextdomain(): void {
        $textdomain = $this->app->make('config')->get('app.textdomain');
        $path       = $this->app->make('config')->get('app.path');

        // Load the textdomain, this is WP core function
        load_theme_textdomain($textdomain, $path . '/languages');
    }

    /**
     * Boot the provider
     * @return void
     */
    public function boot() {
        // Nothing to do here
    }
}
