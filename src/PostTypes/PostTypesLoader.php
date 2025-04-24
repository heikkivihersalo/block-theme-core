<?php

declare(strict_types=1);

namespace Vihersalo\Core\PostTypes;

class PostTypesLoader {
    /**
     * The application instance.
     * @var Application
     */
    protected $app;

    /**
     * Post types
     *
     * @var array
     */
    protected array $postTypes = [];

    /**
     * Constructor
     */
    public function __construct($app) {
        $this->app = $app;
        $this->load();
    }

    /**
     * Load custom post type classes dynamically
     *
     * @return void
     * @throws WP_Error If the class file does not exist.
     */
    public function load(): void {
        $path      = rtrim($this->app->make('config')->get('app.cpt.path'), '/\\');
        $namespace = $this->app->make('config')->get('app.cpt.namespace');
        $classes   = scandir($this->app->make('path') . '/' . $path);

        foreach ($classes as $class) {
            // Remove unnecessary files (e.g. .gitignore, .DS_Store, ., .. etc.)
            if ('.' === $class || '..' === $class || '.DS_Store' === $class || strpos($class, '.') === true) {
                continue;
            }

            $path  = $path . '/' . $class;
            $class = Utils::removeFileExtension($class);
            $slug  = Utils::camelcaseToKebabcase($class);

            $classname = $namespace . '\\' . $class;

            // Get the class file, only try to require if not already imported
            if (! class_exists($classname)) {
                require $path;
            }

            if (! class_exists($classname)) {
                return;
            }

            // Check if the class is already registered
            if (isset($this->postTypes[$slug])) {
                continue;
            }

            // Add the class to the post types array
            $this->postTypes[$slug] = $classname;
        }
    }

    /**
     * Get the post types
     *
     * @return array
     */
    public function all(): array {
        return $this->postTypes;
    }
}
