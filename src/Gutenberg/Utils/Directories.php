<?php

declare(strict_types=1);

namespace Vihersalo\Core\Gutenberg\Utils;

final class Directories {
    /**
     * This utility class should never be instantiated.
     */
    private function __construct() {
    }

    /**
     * Get block directories
     * Can be used to get all blocks that needs to be registered
     * @param string $path Path to block directory
     * @param string $namespace Namespace of block (e.g. core, ksd, custom)
     * @return array
     */
    public static function getBlockDirectories(string $namespace, ?string $path = null): array {
        if (null === $path) {
            return [];
        }

        // Check if path exists
        if (!is_dir($path)) {
            // TODO: Add notice

            return [];
        }

        foreach (scandir($path) as $block) {
            // Remove unnecessary files (e.g. .gitignore, .DS_Store, ., .. etc.)
            if ('.' === $block || '..' === $block || '.DS_Store' === $block || strpos($block, '.') === true) {
                continue;
            }

            // Add block to array
            $blocks[] = $namespace . '/' . $block;

            // Check if block is core block and has child blocks
            // E.g. core/buttons, core/list
            if ('core' === $namespace) :
                switch ($block) {
                    case 'buttons':
                        $blocks[] = 'core/button';
                        break;
                    case 'list':
                        $blocks[] = 'core/list-item';
                        break;
                    default:
                        break;
                }
            endif;
        }

        return $blocks ?? [];
    }

    /**
     * Fix file paths to get blocks working in theme context
     * @return string $url The fixed file path
     */
    public static function fixBlockFilePath(string $url): string {
        if (strpos($url, SITE_PATH) !== false) {
            $url = str_replace('wp-content/plugins' . ABSPATH, '', $url);
        }

        return $url;
    }
}
