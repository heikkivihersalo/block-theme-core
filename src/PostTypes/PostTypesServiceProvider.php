<?php

declare(strict_types=1);

namespace Vihersalo\Core\PostTypes;

use Vihersalo\Core\Foundation\HooksStore;
use Vihersalo\Core\Support\ServiceProvider;
use Vihersalo\Core\Support\Utils\Formatting as Utils;

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
     * Load custom post type classes dynamically
     *
     * @since 0.1.0
     * @access public
     * @return void
     * @throws WP_Error If the class file does not exist.
     */
    public function registerCustomPostTypes(): void {
        $path    = rtrim($this->app->make('config')->get('app.cpt.path'), '/\\');
        $classes = $path;

        foreach ($classes as $class) {
            // Remove unnecessary files (e.g. .gitignore, .DS_Store, ., .. etc.)
            if ('.' === $class || '..' === $class || '.DS_Store' === $class || strpos($class, '.') === true) {
                continue;
            }

            $path  = $path . '/' . $class;
            $class = Utils::removeFileExtension($class);
            $slug  = Utils::camelcaseToKebabcase($class);

            $classname = 'Vihersalo\Core\PostTypes' . '\\' . $class;

            // Get the class file, only try to require if not already imported
            if (! class_exists($classname)) {
                require $path;
            }

            if (! class_exists($classname)) {
                return;
            }

            $class_instance = new $classname();
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
