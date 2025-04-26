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
        $loader    = $this->app->make(HooksStore::class);
        $postTypes = $this->app->make(PostTypesLoader::class)->all();

        $this->registerCustomPostTypes($loader, $postTypes);
        $this->registerEnqueue($loader);
    }

    /**
     * Load custom post types
     *
     * @param HooksStore $loader The loader instance
     * @param array $postTypes The post types to load
     * @return void
     */
    public function registerCustomPostTypes(HooksStore $loader, array $postTypes): void {
        foreach ($postTypes as $postType) {
            if (! class_exists($postType)) {
                continue;
            }

            $instance = new $postType();
            $loader->addAction('after_setup_theme', $instance, 'registerPostType');
            $loader->addAction('init', $instance, 'registerCustomFields');
            $loader->addAction('init', $instance, 'registerBlockBindings');
            $loader->addAction('rest_api_init', $instance, 'registerRestFields');

            $this->registerPermalink($loader, $instance);
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
     * Register permalink settings
     *
     * @param HooksStore $loader The loader instance
     * @param object $postType The post type instance
     * @return void
     */
    public function registerPermalink(HooksStore $loader, $postType): void {
        if (method_exists($postType, 'addPermalinkField')) {
            $loader->addAction('admin_init', $postType, 'addPermalinkField');
        }

        if (method_exists($postType, 'savePermalink')) {
            $loader->addAction('admin_init', $postType, 'savePermalink');
        }
    }

    /**
     * Boot the provider
     * @return void
     */
    public function boot() {
        // Nothing to do here
    }
}
