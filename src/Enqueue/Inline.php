<?php // phpcs:disable

declare(strict_types=1);

namespace Vihersalo\Core\Enqueue;

use Vihersalo\Core\Foundation\Application;
use Vihersalo\Core\Foundation\WP_Hooks;

require_once ABSPATH . 'wp-admin/includes/class-wp-filesystem-base.php';
require_once ABSPATH . 'wp-admin/includes/class-wp-filesystem-direct.php';

use WP_Filesystem_Direct;

class Inline extends Asset {
    /**
     * Create a new instance of Enqueue
     * @param Application $app The application instance
     * @param string $handle The handle of enqueued asset
     * @param string $path The URI of enqueued asset file
     * @param int    $priority The priority of the enqueued asset
     * @return self
     */
    public static function create($app, string $handle, string $path, int $priority = 10): self {
        return new self($app, $handle, '', $path, '', $priority, false);
    }

    /**
     * Enqueue the script
     * @return void
     */
    public function enqueue() {
        $filesystem = new WP_Filesystem_Direct(true);
        $id         = $this->getHandle();
        $path       = $this->app->make('path') . '/' . $this->getPath();

        if (! $filesystem->exists($path)) {
            return;
        }

        ?>
        <style id="<?php echo esc_attr($id); ?>">
            <?php echo $filesystem->get_contents($path); ?>
        </style>
        <?php
    }

    /**
     * Register the script
     * @return void
     */
    public function register(): void {
        $this->app->make(WP_Hooks::class)->addAction('wp_head', $this, 'enqueue', $this->getPriority());
    }
}
