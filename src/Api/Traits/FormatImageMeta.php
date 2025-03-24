<?php

declare(strict_types=1);
/**
 * Register custom image sizes
 *
 * @link       https://www.kotisivu.dev
 * @since      1.0.0
 *
 * @package    Vihersalo\Core\Common
 */

namespace Vihersalo\Core\Theme\Api\Traits;

/**
 * Register custom image sizes
 *
 * @since      1.0.0
 * @package    Vihersalo\Core\Common
 * @author     Heikki Vihersalo <heikki@vihersalo.fi>
 */
trait FormatImageMeta {
    /**
     * Get featured image metadata
     * @param mixed  $post_id Post ID
     * @param string $size Default: medium
     * @return array
     */
    public function getFeaturedImageMeta(mixed $post_id, string $size = 'medium') {
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
