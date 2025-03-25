<?php

declare(strict_types=1);

namespace Vihersalo\Core\Junk;

final class Utils {
    /**
     * This is a junk utils class and should not be initialized
     */
    private function __construct() {
    }

    /**
     * Remove WP duotone filters
     *
     * @since    1.0.0
     * @access   private
     * @return   void
     */
    public static function removeDuotoneFilters() {
        remove_action('wp_body_open', 'wp_global_styles_render_svg_filters');
        remove_action('in_admin_header', 'wp_global_styles_render_svg_filters');
    }

    /**
     * Remove jQuery Migrate script
     * Original code from: https://dotlayer.com/what-is-migrate-js-why-and-how-to-remove-jquery-migrate-from-wordpress/
     * @param object $scripts The registered scripts
     * @return  void
     */
    public static function removeJqueryMigrate($scripts): void {
        if (! isAdmin() && isset($scripts->registered['jquery'])) {
            $script = $scripts->registered['jquery'];

            if ($script->deps) { // Check whether the script has any dependencies
                $script->deps = array_diff(
                    $script->deps,
                    [
                        'jquery-migrate',
                    ]
                );
            }
        }
    }

    /**
     * Disable jQuery
     * @return void
     */
    public static function moveJqueryToFooter(): void {
        if (is_user_logged_in()) {
            return;
        }

        wp_scripts()->add_data('jquery', 'group', 1);
        wp_scripts()->add_data('jquery-core', 'group', 1);
        wp_scripts()->add_data('jquery-migrate', 'group', 1);
    }

    /**
     * Disable WP emojis from TinyMCE
     * @param array $plugins
     * @return array
     */
    public static function disableEmojisTinymce($plugins): array {
        return is_array($plugins) ? array_diff($plugins, ['wpemoji']) : [];
    }

    /**
     * Disable WP emojis DNS prefetch
     * @param array  $urls Emojis URLs
     * @param string $relation_type string
     * @return array
     */
    public static function disableEmojisRemoveDnsPrefetch(array $urls, string $relation_type): array {
        if ('dns-prefetch' !== $relation_type) {
            return $urls;
        }

        $svg_url = preg_grep('/images\/core\/emoji/', $urls);

        if (empty($svg_url)) {
            return $urls;
        }

        $svg_url = reset($svg_url);
        $svg_url = apply_filters('emoji_svg_url', $svg_url);
        $urls    = array_diff($urls, [$svg_url]);

        return $urls;
    }
}
