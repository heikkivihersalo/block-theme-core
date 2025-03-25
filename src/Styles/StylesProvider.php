<?php

declare(strict_types=1);

namespace Vihersalo\Core\Styles;

use Vihersalo\Core\Application\HooksLoader;
use Vihersalo\Core\Support\ServiceProvider;

class StylesProvider extends ServiceProvider {
    /**
     * Register the navigation provider
     */
    public function register() {
        $this->inlineMetaStyles();
    }

    /**
     * Register theme meta styles
     * @return   void
     */
    public function inlineMetaStyles() {
        $color = $this->app->make('config')->get('app.theme.meta');

        $scheme = new Scheme($color);

        $this->app->make(HooksLoader::class)->addAction('wp_head', $scheme, 'inlineThemeColor', 0);
    }

    /**
     * Boot the navigation provider
     */
    public function boot() {
    }
}
