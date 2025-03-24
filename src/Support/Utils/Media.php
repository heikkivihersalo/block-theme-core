<?php

declare(strict_types=1);

namespace Vihersalo\Core\Support\Utils;

final class Media {
    /**
     * This utility class should never be instantiated.
     */
    private function __construct() {
    }

    /**
     * Enqueue media support
     * @return void
     */
    public static function addWpMediaSupport(): void {
        wp_enqueue_media();
    }

    /**
     * Add image support for SVG's
     *
     * @param array $mimes Mime types
     * @return array
     */
    public static function allowSvgUploads(array $mimes): array {
        $mimes['svg'] = 'image/svg+xml';
        return $mimes;
    }

    /**
     * Get featured image metadata
     * @param mixed  $post_id Post ID
     * @param string $size Default: medium
     * @return array
     */
    public static function getFeaturedImageMeta(mixed $post_id, string $size = 'medium') {
        $id   = get_post_thumbnail_id($post_id);
        $meta = wp_get_attachment_image_src($id, $size);

        return [
            'id'     => $id,
            'url'    => $meta[0] ?? '',
            'width'  => $meta[1] ?? '',
            'height' => $meta[2] ?? '',
            'alt'    => get_post_meta($id, '_wp_attachment_image_alt', true),
            'title'  => get_the_title($id),
        ];
    }
}
