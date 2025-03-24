<?php

declare(strict_types=1);

namespace Vihersalo\Core\Translations;

use Vihersalo\Core\Application\HooksLoader;
use Vihersalo\Core\Support\ServiceProvider;

class TranslationProvider extends ServiceProvider {
    /**
     * Register the navigation provider
     * @return void
     */
    public function register() {
        $this->app->make(HooksLoader::class)->addAction('after_setup_theme', $this, 'loadTextdomain');
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
     * Boot the navigation provider
     * @return void
     */
    public function boot() {
    }
}
