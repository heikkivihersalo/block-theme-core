<?php

declare(strict_types=1);

namespace Vihersalo\Core\PostTypes;

use Vihersalo\Core\Foundation\HooksStore;
use Vihersalo\Core\Support\ServiceProvider;

class PostTypesServiceProvider extends ServiceProvider {
    /**
     * Register the provider
     * @return void
     */
    public function register() {
        $loader = $this->app->make(HooksStore::class);
        $loader->addAction('after_setup_theme', $this, 'registerCustomPostTypes');

        $this->registerEnqueue($loader);
    }

    /**
     * Load custom post types
     * @return void
     */
    public function registerCustomPostTypes(): void {
        $postTypes = $this->app->make(PostTypesLoader::class)->all();

        foreach ($postTypes as $postType) {
            if (! class_exists($postType)) {
                continue;
            }

            $instance = (new $postType())->register();
        }
    }

    /**
     * Enqueue the assets
     *
     * @param HooksStore $loader The loader instance
     * @return void
     */
    public function registerEnqueue(HooksStore $loader): void {
        $enqueue = new Enqueue($this->app->make('path'), $this->app->make('uri'));
        $loader->addAction('admin_enqueue_scripts', $enqueue, 'enqueueEditorAssets');
    }

    /**
     * Boot the provider
     * @return void
     */
    public function boot() {
        // Nothing to do here
    }
}
