<?php

declare(strict_types=1);

namespace Vihersalo\Core\Enqueue;

use Vihersalo\Core\Application;
use Vihersalo\Core\Support\Notice;

abstract class Asset {
    /**
     * App instance
     * @var Application
     */
    protected $app;

    /**
     * The handle of enqueued asset
     * @var string
     */
    protected $handle;

    /**
     * The src of enqueued asset
     * @var string
     */
    protected $src;

    /**
     * The path of enqueued asset
     * @var string
     */
    protected $path;

    /**
     * The asset file path
     * @var string
     */
    protected $asset;

    /**
     * The priority of the enqueued asset
     * @var int
     */
    protected $priority;

    /**
     * Whether the asset is for admin or not
     * @var bool
     */
    protected $admin;

    /**
     * Whether the asset is for `add_editor_style` function or not
     * @var bool
     */
    protected $editor;

    /**
     * Constructor
     *
     * @param string $handle The handle of enqueued asset
     * @param string $src The src of enqueued asset
     * @param string $path The path of enqueued asset
     * @param string $asset The asset file path
     * @param int    $priority The priority of the enqueued asset
     * @param bool   $admin Whether the asset is for admin or not
     * @param bool   $editor Whether the asset is for `add_editor_style` function or not
     *
     * @since 1.0.0
     * @access private
     * @return void
     */
    public function __construct(
        string $handle = '',
        string $src = '',
        string $path = '',
        string $asset = '',
        int $priority = 10,
        bool $admin = false,
        bool $editor = false
    ) {
        $this->handle   = $handle;
        $this->src      = $src;
        $this->path     = $path;
        $this->asset    = $asset;
        $this->priority = $priority;
        $this->admin    = $admin;
        $this->editor   = $editor;
        $this->app      = Application::getInstance();
    }

    /**
     * Get the handle of enqueued asset
     *
     * @return string
     */
    public function getHandle(): string {
        return $this->handle;
    }

    /**
     * Get the URI of enqueued asset
     *
     * @return string
     */
    public function getSrc(): string {
        return $this->src;
    }

    /**
     * Get the path of enqueued asset
     *
     * @return string
     */
    public function getPath(): string {
        return $this->path;
    }

    /**
     * Get the priority of enqueued asset
     *
     * @return int
     */
    public function getPriority(): int {
        return $this->priority;
    }

    /**
     * Get the admin boolean of enqueued asset
     *
     * @return bool
     */
    public function isAdmin(): bool {
        return $this->admin;
    }

    /**
     * Get the editor boolean of enqueued asset
     *
     * @return bool
     */
    public function isEditor(): bool {
        return $this->editor;
    }

    /**
     * Get the asset file path
     *
     * @return string
     */
    public function getAssetPath(): string {
        if ('' === $this->asset) :
            return '';
        endif;

        if (! $this->assetExists()) :
            return '';
        endif;

        return $this->asset;
    }

    /**
     * Enqueue the asset in the admin
     *
     * @return void
     */
    public function addToEditorStyles() {
        add_editor_style($this->app->make('config')->get('uri') . '/' . $this->getSrc());
    }

    /**
     * Check if the asset exists
     *
     * @return bool
     */
    public function assetExists(): bool {
        $path = $this->app->make('config')->get('app.path');

        if (! file_exists(trailingslashit($path) . $this->asset)) :
            $message = sprintf(
                /* translators: %1$s is the path to the asset */
                __(
                    'Asset in a path "%1$s" are missing. Run `yarn` and/or `yarn build` to generate them.',
                    'vihersalo-block-theme-core'
                ),
                $this->asset
            );

            $notice = new Notice($message);
            $notice->display();

            return false;
        endif;

        return true;
    }

    /**
     * Register the asset
     */
    abstract public function register(): void;
}
