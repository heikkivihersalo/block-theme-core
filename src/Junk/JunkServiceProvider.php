<?php

declare(strict_types=1);

namespace Vihersalo\Core\Junk;

use Vihersalo\Core\Application\HooksLoader;
use Vihersalo\Core\Support\ServiceProvider;
use Vihersalo\Core\Support\Utils\Common as CommonUtils;

class JunkServiceProvider extends ServiceProvider {
    /**
     * Register the navigation provider
     * @return void
     */
    public function register() {
        $loader = $this->app->make(HooksLoader::class);
        $this->setJqueryOptimizations($loader);
        $this->removeWpEmojis($loader);
        $this->removeWpDefaultJunk($loader);
        $this->removeAssetJunk($loader);
    }

    /**
     * Register all of the hooks related to the optimized jQuery
     * @param HooksLoader $loader The loader to use
     * @return   void
     */
    public function setJqueryOptimizations(HooksLoader $loader) {
        $loader->addAction('wp_default_scripts', Utils::class, 'removeJqueryMigrate');
        $loader->addAction('wp_enqueue_scripts', Utils::class, 'moveJqueryToFooter');
    }

    /**
     * Remove WP emojis
     * @param HooksLoader $loader The loader to use
     * @return   void
     */
    public function removeWpEmojis(HooksLoader $loader) {
        $loader->removeAction('wp_head', 'print_emoji_detection_script', 7);
        $loader->removeAction('admin_print_scripts', 'print_emoji_detection_script');
        $loader->removeAction('wp_print_styles', 'print_emoji_styles');
        $loader->removeAction('admin_print_styles', 'print_emoji_styles');
        $loader->removeFilter('wp_mail', 'wp_staticize_emoji_for_email');
        $loader->removeFilter('the_content_feed', 'wp_staticize_emoji');
        $loader->removeFilter('comment_text_rss', 'wp_staticize_emoji');
        $loader->addFilter('tiny_mce_plugins', Utils::class, 'disableEmojisTinymce');
        $loader->addFilter('emoji_svg_url', CommonUtils::class, 'returnFalse');
        $loader->addFilter('wp_resource_hints', Utils::class, 'disableEmojisRemoveDnsPrefetch', 1, 2);
    }

    /**
     * Remove WP default junk
     * @param HooksLoader $loader The loader to use
     * @return   void
     */
    public function removeWpDefaultJunk(HooksLoader $loader) {
        /**
         * Remove canonical links
         */
        $loader->removeAction('embed_head', 'rel_canonical');
        $loader->removeAction('wp_head', 'rel_canonical');
        $loader->addFilter('wpseo_canonical', null, '__returnFalse');

        /**
         * Remove feed links
         */
        $loader->removeAction('wp_head', 'feed_links', 2);
        $loader->removeAction('wp_head', 'feed_links_extra', 3);

        /**
         * Remove gravatar
         */
        $loader->addFilter('get_avatar', null, '__returnFalse');
        $loader->addFilter('option_show_avatars', null, '__returnFalse');

        /**
         * Remove next and previous links
         */
        $loader->removeAction('wp_head', 'adjacent_posts_rel_link', 10);
        $loader->removeAction('wp_head', 'adjacent_posts_rel_link_wp_head', 10);

        /**
         * Remove RSD link
         */
        $loader->removeAction('wp_head', 'rsd_link');

        /**
         * Remove shortlink
         */
        $loader->removeAction('wp_head', 'wp_shortlink_wp_head', 10);
        $loader->removeAction('template_redirect', 'wp_shortlink_header', 11);
    }

    /**
     * Remove asset and media junk
     * @param HooksLoader $loader The loader to use
     * @return   void
     */
    public function removeAssetJunk(HooksLoader $loader) {
        $loader->addAction('after_setup_theme', $this, 'removeDuotoneFilters');
    }

    /**
     * Boot the navigation provider
     * @return void
     */
    public function boot() {
    }
}
