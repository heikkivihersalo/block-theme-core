<?php

declare(strict_types=1);

namespace Vihersalo\Core\PostTypes;

use Vihersalo\Core\Support\Utils\Common as Utils;

class Enqueue {
    /**
     * Constructor
     *
     * @param string $path The base path
     * @param string $uri The base URI
     * @return void
     */
    public function __construct(string $path, string $uri) {
        $this->path = $path;
        $this->uri  = $uri;
    }

    /**
     * Run the editor scripts and styles
     *
     * @since    0.2.0
     * @param string $hook The current admin page
     * @return void
     */
    public function enqueueEditorAssets(string $hook = ''): void {
        if (! Utils::isEditorPage($hook)) {
            return;
        }

        wp_enqueue_script(
            'app-post-type',
            $this->uri . '/vendor/vihersalo/block-theme-core/src/PostTypes/Assets/main.js',
            [],
            null,
            true
        );

        wp_enqueue_style(
            'app-post-type',
            $this->uri . '/vendor/vihersalo/block-theme-core/src/PostTypes/Assets/main.js',
            [],
            null,
            'all'
        );
    }
}
