<?php

declare(strict_types=1);

namespace Vihersalo\Core\Styles;

use Vihersalo\Core\Foundation\HooksStore;
use Vihersalo\Core\Support\ServiceProvider;

class StylesServiceProvider extends ServiceProvider {
    /**
     * Register the provider
     * @return void
     */
    public function register() {
        $store = $this->app->make(HooksStore::class);
        $this->inlineMetaStyles($store);
    }

    /**
     * Register theme meta styles
     * @param HooksStore $store The WordPress hooks loader
     * @return void
     */
    public function inlineMetaStyles(HooksStore $store) {
        $color = $this->app->make('config')->get('app.theme.meta');

        $scheme = new Scheme($color, false);

        $store->addAction('wp_head', $scheme, 'inlineThemeColor', 0);
    }

    /**
     * Boot the provider
     * @return void
     */
    public function boot() {
        // Nothing to do here
    }
}
