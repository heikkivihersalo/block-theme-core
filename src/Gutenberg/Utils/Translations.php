<?php

declare(strict_types=1);

namespace Vihersalo\Core\Gutenberg\Utils;

final class Translations {
    /**
     * This utility class should never be instantiated.
     */
    private function __construct() {
    }

    /**
     * Set block translation
     * @param string $block_slug Block slug
     * @param string $path Path to block
     * @return void
     */
    public static function setBlockTranslation($block_slug, $path): void {
        wp_set_script_translations(
            $block_slug,
            SITE_TEXTDOMAIN,
            $path . '/languages'
        );

        add_filter(
            'load_script_translation_file',
            function (string $file, string $handle, string $domain) use ($block_slug, $path) {
                if (strpos($handle, $block_slug) !== false && SITE_TEXTDOMAIN === $domain) {
                    $file = str_replace(WP_LANG_DIR . '/plugins', $path . '/languages', $file);
                }

                return $file;
            },
            10,
            3
        );
    }
}
