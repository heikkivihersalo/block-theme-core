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

        foreach ($postTypes as $postType) {
            if (! class_exists($postType)) {
                continue;
            }

            // Initialize and add the post type
            $instance = new $postType();
            $loader->addAction('after_setup_theme', $instance, 'registerPostType');

            // Register the post type features
            $this->registerCustomFields($loader, $instance);
            $this->registerRestAPI($loader, $instance);
            $this->registerBlockBindings($loader, $instance);
            $this->registerPermalink($loader, $instance);
        }

        $this->registerEnqueue($loader);
    }

    /**
     * Register custom fields
     *
     * @param HooksStore $loader The loader instance
     * @param object $postType The post type instance
     * @return void
     */
    public function registerCustomFields(HooksStore $loader, $postType): void {
        if (method_exists($postType, 'registerCustomFields')) {
            $loader->addAction('init', $postType, 'registerCustomFields');
        }
    }

    /**
     * Register permalink settings
     *
     * @param HooksStore $loader The loader instance
     * @param object $postType The post type instance
     * @return void
     */
    public function registerRestAPI(HooksStore $loader, $postType): void {
        if (method_exists($postType, 'registerRestFields')) {
            $loader->addAction('rest_api_init', $postType, 'registerRestFields');
        }
    }

    /**
     * Register block bindings
     *
     * @param HooksStore $loader The loader instance
     * @param object $postType The post type instance
     * @return void
     */
    public function registerBlockBindings(HooksStore $loader, $postType): void {
        if (method_exists($postType, 'registerBlockBindings')) {
            $loader->addAction('rest_api_init', $postType, 'registerBlockBindings');
        }
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
