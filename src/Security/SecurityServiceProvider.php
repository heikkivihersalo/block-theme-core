<?php

declare(strict_types=1);

namespace Vihersalo\Core\Security;

use Vihersalo\Core\Foundation\HooksStore;
use Vihersalo\Core\Support\ServiceProvider;
use Vihersalo\Core\Support\Utils\Common as CommonUtils;

class SecurityServiceProvider extends ServiceProvider {
    /**
     * Register the provider
     * @return void
     */
    public function register() {
        $store  = $this->app->make(HooksStore::class);
        $config = $this->app->make('config')->get('security');

        if (! $config['version']) {
            $this->removeWpVersion($store);
        }

        if (! $config['rsd_links']) {
            $this->removeRsdLinks($store);
        }

        if (! $config['wlwmanifest']) {
            $this->removeWlwmanifestLink($store);
        }

        if (! $config['xmlrpc']) {
            $this->disableXmlrpc($store);
        }

        if (! $config['theme_updates']) {
            $this->disableThemeUpdate($store);
        }

        if (! $config['post_links']) {
            $this->removeRelPrevPostLinks($store);
        }

        if (! $config['shortlink']) {
            $this->removeShortlink($store);
        }

        if (! $config['canonical']) {
            $this->removeCanonical($store);
        }

        if (! $config['feed_links']) {
            $this->removeFeedLinks($store);
        }

        if (! $config['rest_api_tags']) {
            $this->removeRestApiTags($store);
        }

        if (! $config['oembed_links']) {
            $this->removeOembedLinks($store);
        }

        if (! $config['resource_hints']) {
            $this->removeResourceHints($store);
        }

        if (! $config['robots_max_image_preview_large']) {
            $this->removeRobotsMaxImagePreview($store);
        }

        if (! $config['emoji']) {
            $this->removeEmoji($store);
        }

        if ($config['jquery_to_footer']) {
            $this->moveJqueryToFooter($store);
        }

        if (! $config['jquery_migrate']) {
            $this->removeJqueryMigrate($store);
        }

        if (! $config['duotone_filters']) {
            $this->removeDuotoneFilters($store);
        }
    }

    /**
     * Don't print tags for the XML-RPC discover mechanism.
     * @return   void
     */
    public function removeRsdLinks(HooksStore $store) {
        $store->removeAction('wp_head', 'rsd_link', 10);
    }

    /**
     * Don't print tags used by Windows Live Writer.
     * @return   void
     */
    public function removeWlwmanifestLink(HooksStore $store) {
        $store->removeAction('wp_head', 'wlwmanifest_link', 10);
    }

    /**
     * Disable XML-RPC
     * @param HooksStore $store The loader to use
     * @return void
     */
    public function disableXmlrpc(HooksStore $store) {
        $store->addFilter('xmlrpc_enabled', CommonUtils::class, 'returnFalse');
    }

    /**
     * Don't print the WordPress version.
     * @return   void
     */
    public function removeWpVersion(HooksStore $store) {
        $store->removeAction('wp_head', 'wp_generator', 10);
        $store->removeAction('wp_head', 'wc_generator_tag', 10);
    }

    /**
     * Remove theme update checks
     * @return   void
     */
    public function disableThemeUpdate(HooksStore $store) {
        $store->addFilter('http_request_args', Utils::class, 'disableThemeUpdate', 10, 2);
    }

    /**
     * Don't print rel or prev/next links.
     * @param HooksStore $store The loader to use
     * @return void
     */
    public function removeRelPrevPostLinks(HooksStore $store) {
        $store->removeAction('wp_head', 'start_post_rel_link', 10);
        $store->removeAction('wp_head', 'index_rel_link', 10);
        $store->removeAction('wp_head', 'adjacent_posts_rel_link', 10);
        $store->removeAction('wp_head', 'adjacent_posts_rel_link_wp_head', 10);
    }

    public function removeShortlink(HooksStore $store) {
        $store->removeAction('wp_head', 'wp_shortlink_wp_head', 10);
        $store->removeAction('template_redirect', 'wp_shortlink_header', 11);
    }

    /**
     * Don't print post canonical link.
     * @return   void
     */
    public function removeCanonical(HooksStore $store) {
        $store->removeAction('wp_head', 'rel_canonical', 10);
    }

    /**
     * Don\'t print links for the posts and comments feeds.
     * @param HooksStore $store The loader to use
     * @return void
     */
    public function removeFeedLinks(HooksStore $store) {
        $store->removeAction('wp_head', 'feed_links', 2);
        $store->removeAction('wp_head', 'feed_links_extra', 3);
    }

    /**
     * Don't print the REST API endpoint tags.
     * @param HooksStore $store The loader to use
     * @return void
     */
    public function removeRestApiTags(HooksStore $store) {
        $store->removeAction('wp_head', 'rest_output_link_wp_head', 10);
        $store->removeAction('wp_head', 'wp_oembed_add_discovery_links', 10);
    }

    /**
     * Remove oEmbed discovery links.
     * @param HooksStore $store The loader to use
     * @return void
     */
    public function removeOembedLinks(HooksStore $store) {
        $store->removeAction('wp_head', 'wp_oembed_add_discovery_links', 10);
        $store->removeAction('wp_head', 'wp_oembed_add_host_js');
        $store->removeAction('rest_api_init', 'wp_oembed_register_route');
        $store->removeFilter('oembed_dataparse', 'wp_filter_oembed_result', 10);
    }

    /**
     * Don't print tags for browser pre-fetching, pre-rendering, and pre-connecting hints.
     * @param HooksStore $store The loader to use
     * @return void
     */
    public function removeResourceHints(HooksStore $store) {
        $store->removeAction('wp_head', 'wp_resource_hints', 2);
    }

    /**
     * Don't print tags for web robots image preview directive.
     * @param HooksStore $store The loader to use
     * @return void
     */
    public function removeRobotsMaxImagePreview(HooksStore $store) {
        $store->removeAction('wp_head', 'wp_robots_max_image_preview_large', 10);
    }

    /**
     * Don't print scripts for emoji support.
     * @param HooksStore $store The loader to use
     * @return void
     */
    public function removeEmoji(HooksStore $store) {
        $store->removeAction('wp_head', 'print_emoji_detection_script', 7);
        $store->removeAction('admin_print_scripts', 'print_emoji_detection_script');
        $store->removeAction('wp_print_styles', 'print_emoji_styles');
        $store->removeAction('admin_print_styles', 'print_emoji_styles');
        $store->removeFilter('wp_mail', 'wp_staticize_emoji_for_email');
        $store->removeFilter('the_content_feed', 'wp_staticize_emoji');
        $store->removeFilter('comment_text_rss', 'wp_staticize_emoji');
        $store->addFilter('tiny_mce_plugins', Utils::class, 'disableEmojisTinymce');
        $store->addFilter('emoji_svg_url', CommonUtils::class, 'returnFalse');
        $store->addFilter('wp_resource_hints', Utils::class, 'disableEmojisRemoveDnsPrefetch', 1, 2);
    }

    /**
     * jQuery optimizations
     * @param HooksStore $store The loader to use
     * @return   void
     */
    public function moveJqueryToFooter(HooksStore $store) {
        if (CommonUtils::isLoggedIn()) {
            return;
        }

        $store->addAction('wp_enqueue_scripts', Utils::class, 'moveJqueryToFooter');
    }

    /**
     * Remove jQuery Migrate script
     * @param HooksStore $store The loader to use
     * @return   void
     */
    public function removeJqueryMigrate(HooksStore $store) {
        if (CommonUtils::isLoggedIn()) {
            return;
        }

        $store->addAction('wp_default_scripts', Utils::class, 'removeJqueryMigrate');
    }

    /**
     * Remove duotone filters
     * @param HooksStore $store The loader to use
     * @return   void
     */
    public function removeDuotoneFilters(HooksStore $store) {
        $store->addAction('after_setup_theme', Utils::class, 'removeDuotoneFilters');
    }

    /**
     * Boot the provider
     * @return void
     */
    public function boot() {
        // Nothing to do here
    }
}
