<?php

declare(strict_types=1);

namespace Vihersalo\Core\Styles;

use Vihersalo\Core\Bootstrap\WP_Hooks;
use Vihersalo\Core\Support\ServiceProvider;

class StylesServiceProvider extends ServiceProvider {
    /**
     * Register the navigation provider
     * @return void
     */
    public function register() {
        $this->inlineMetaStyles();
    }

    /**
     * Register theme meta styles
     * @return void
     */
    public function inlineMetaStyles() {
        $color = $this->app->make('config')->get('app.theme.meta');

        $scheme = new Scheme($color, false);

        $this->app->make(WP_Hooks::class)->addAction('wp_head', $scheme, 'inlineThemeColor', 0);
    }

    /**
     * Boot the navigation provider
     * @return void
     */
    public function boot() {
    }
}
