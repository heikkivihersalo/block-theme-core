<?php

declare(strict_types=1);

namespace Vihersalo\Core\Support\Utils;

use Vihersalo\Core\Support\Notice;

final class Common {
    /**
     * This utility class should never be instantiated.
     */
    private function __construct() {
    }

    /**
     * Return true
     *
     * @return bool
     */
    public static function returnTrue(): bool {
        return true;
    }

    /**
     * Return false
     *
     * @since 1.0.0
     * @return bool
     */
    public static function returnFalse(): bool {
        return false;
    }

    /**
     * Check if the current page is the admin page
     *
     * @since    1.0.0
     * @return bool
     */
    public static function isAdmin(): bool {
        return isAdmin();
    }

    /**
     * Check if the current page is the plugin's editor page
     *
     * @since    1.0.0
     * @param string $hook The current admin page
     * @return bool
     */
    public static function isEditorPage(string $hook): bool {
        return str_contains($hook, 'post-new.php') || str_contains($hook, 'post.php');
    }

    /**
     * Check if the current page is the plugin's editor page
     *
     * @since    1.0.0
     * @param string $hook The current admin page
     * @return bool
     */
    public static function isTermsPage(string $hook): bool {
        return str_contains($hook, 'edit-tags.php') || str_contains($hook, 'term.php');
    }

    /**
     * Check if the asset exists
     *
     * @param string $path The path to the asset
     * @return bool
     */
    public static function assetExists($path): bool {
        if (! file_exists($path)) :
            $message = sprintf(
                /* translators: %1$s is the path to the asset */
                __(
                    'Asset in a path "%1$s" are missing. Run `yarn` and/or `yarn build` to generate them.',
                    'vihersalo-block-theme-core'
                ),
                $path
            );

            $notice = new Notice($message);
            $notice->display();

            return false;
        endif;

        return true;
    }
}
