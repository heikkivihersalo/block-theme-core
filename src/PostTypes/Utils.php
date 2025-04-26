<?php

declare(strict_types=1);

namespace Vihersalo\Core\PostTypes;

/**
 * Utility functions
 *
 * @since      0.1.0
 * @package    Kotisivu\BlockTheme\Theme\Common\Utils
 * @author     Heikki Vihersalo <heikki@vihersalo.fi>
 */
final class Utils {
    /**
     * This utility class should never be instantiated.
     */
    private function __construct() {
    }

    /**
     * Write code on Method
     *
     * @since 0.1.0
     * @access public
     * @param  string $file String to convert
     * @return string
     */
    public static function camelcaseToKebabcase(string $file) {
        return strtolower(preg_replace('/(?<!^)[A-Z]/', '-$0', $file));
    }

    /**
     * Remove file extension from string
     *
     * @since 0.1.0
     * @access public
     * @param  string $file String to convert
     * @return string
     */
    public static function removeFileExtension(string $file) {
        return str_replace('.php', '', $file);
    }

    /**
     * Format post meta image
     *
     * @param int $postId Post ID
     * @param string $metaKey Meta key
     * @return array|null
     */
    public static function formatPostMetaImage($postId, $metaKey) {
        $imageId = \get_post_meta($postId, $metaKey, true);

        if (! $imageId) {
            return null;
        }

        $image = \wp_get_attachment_image_src($imageId, 'full');

        if (! $image) {
            return null;
        }

        return [
            'id'     => (int) $imageId,
            'url'    => $image[0]                                      ?? '',
            'width'  => $image[1]                                      ?? 0,
            'height' => $image[2]                                      ?? 0,
            'sizes'  => \wp_get_attachment_metadata($imageId)['sizes'] ?? [],
            'alt'    => \get_post_meta($imageId, '_wp_attachment_image_alt', true),
        ];
    }
}
