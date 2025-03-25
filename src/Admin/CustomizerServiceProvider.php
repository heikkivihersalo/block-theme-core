<?php

declare(strict_types=1);

namespace Vihersalo\Core\Admin;

use Vihersalo\Core\Bootstrap\WP_Hooks;
use Vihersalo\Core\Support\ServiceProvider;
use Vihersalo\Core\Support\Utils\Common as Utils;

class CustomizerServiceProvider extends ServiceProvider {
    /**
     * Register the navigation provider
     * @return void
     */
    public function register() {
        $this->enableCustomizer();
    }

    /**
     * Enable customizer
     * @return void
     */
    private function enableCustomizer() {
        $this->app->make(WP_Hooks::class)->addAction('customize_register', Utils::class, 'returnTrue');
    }

    /**
     * Boot the navigation provider
     * @return void
     */
    public function boot() {
    }
}
