<?php

declare(strict_types=1);

namespace Vihersalo\Core\Theme;

use Vihersalo\Core\Theme\Common\Loader;
use Vihersalo\Core\Theme\Common\Utils\Security as SecurityUtils;

class Security {
    /**
     * Constructor
     *
     * @since    1.0.0
     * @access   public
     */
    public function __construct(Loader $loader) {
        $this->loader = $loader;
    }

    /**
     * Register all of the hooks related to the API security enhancements
     *
     * @since    1.0.0
     * @access   private
     * @return   void
     */
    private function remove_json_api() {
        /**
         * Remove JSON API
         */
        $this->loader->add_filter('json_enabled', null, '__returnFalse');
        $this->loader->add_filter('json_jsonp_enabled', null, '__returnFalse');
        $this->loader->add_filter('rest_jsonp_enabled', null, '__returnFalse');
        $this->loader->add_filter('embed_oembed_discover', null, '__returnFalse');

        $this->loader->remove_action('wp_head', 'rest_output_link_wp_head', 10);
        $this->loader->remove_action('wp_head', 'wp_oembed_add_discovery_links', 10);
        $this->loader->remove_action('rest_api_init', 'wp_oembed_register_route');
        $this->loader->remove_filter('oembed_dataparse', 'wp_filter_oembed_result', 10);
        $this->loader->remove_action('wp_head', 'wp_oembed_add_discovery_links');
        $this->loader->remove_action('wp_head', 'wp_oembed_add_host_js');
        $this->loader->remove_action('template_redirect', 'rest_output_link_header', 11, 0);
    }

    /**
     * Register all of the hooks related to the API security enhancements
     *
     * @since    1.0.0
     * @access   private
     * @return   void
     */
    private function remove_unsecure_endpoints() {
        $this->loader->add_filter('rest_endpoints', SecurityUtils::class, 'disableRestApiUserEndpoints');
    }

    /**
     * Register all of the hooks related to the security enhancements
     *
     * @since    1.0.0
     * @access   private
     * @return   void
     */
    private function set_security_enhancements() {
        $this->loader->add_action('wp_default_scripts', $this, 'disable_xmlrpc', 9999);
        $this->loader->add_action('template_redirect', SecurityUtils::class, 'disableAuthorPages');
        $this->loader->add_filter('http_request_args', SecurityUtils::class, 'disableThemeUpdate', 10, 2);
    }

    /**
     * Remove WordPress version from header
     *
     * @since 1.0.0
     * @access private
     * @return void
     */
    private function remove_wp_versions() {
        $this->loader->remove_action('wp_head', 'wp_generator');
        $this->loader->remove_action('wp_head', 'wc_generator_tag');
    }

    /**
     * Disable XML-RPC
     *
     * @since 1.0.0
     * @access private
     * @return void
     */
    public function disable_xmlrpc() {
        $this->loader->add_filter('xmlrpc_enabled', null, '__returnFalse');
    }

    /**
     * @inheritDoc
     */
    public function registerHooks() {
        $this->remove_json_api();
        $this->remove_unsecure_endpoints();
        $this->set_security_enhancements();
        $this->remove_wp_versions();
        $this->disable_xmlrpc();
    }
}
