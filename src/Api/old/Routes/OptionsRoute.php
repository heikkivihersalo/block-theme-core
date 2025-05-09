<?php

declare(strict_types=1);
/**
 * OptionsRoute class
 *
 * @link       https://www.kotisivu.dev
 * @since      1.0.0
 *
 * @package    Vihersalo\Core\Theme\Api\Routes\OptionsRoute
 */

namespace Vihersalo\Core\Theme\Api\Routes;

defined('ABSPATH') || die();

use Exception;
use Vihersalo\Core\Theme\Api\Enums\HTTP_Success;
use Vihersalo\Core\Theme\Api\Enums\Permission;
use Vihersalo\Core\Theme\Api\Interfaces\RouteInterface;
use Vihersalo\Core\Theme\Api\Utils\OptionsUtils;
use Vihersalo\Core\Theme\Common\Utils\Options as Utils;
use WP_Error;
use WP_REST_Request;
use WP_REST_Response;
use WP_REST_Server;

/**
 * OptionsRoute class
 *
 * @since      1.0.0
 * @package    Vihersalo\Core\Theme\Api\Routes\OptionsRoute
 * @author     Heikki Vihersalo <heikki@vihersalo.fi>
 */
class OptionsRoute extends BaseRoute implements RouteInterface {
    /**
     * Register custom domain related rest routes
     * @return void
     */
    public function register_custom_endpoints(): void {
        /**
         * Route for fetching contact information
         * @method GET
         */
        register_rest_route(
            RouteInterface::NAMESPACE . RouteInterface::VERSION,
            '/' . $this->base . '/contact',
            [
                'methods'             => WP_REST_Server::READABLE, // Alias for GET transport method.
                'callback'            => [$this, 'get_contact_settings'],
                'permission_callback' => Permission::PUBLIC->get_callback(),
            ]
        );

        /**
         * Route for updating contact information
         * @method POST
         */
        register_rest_route(
            RouteInterface::NAMESPACE . RouteInterface::VERSION,
            '/' . $this->base . '/contact',
            [
                'methods'             => WP_REST_Server::EDITABLE, // Alias for POST transport method.
                'callback'            => [$this, 'update_contact_settings'],
                'permission_callback' => Permission::ADMIN->get_callback(),
            ]
        );

        /**
         * Route for fetching social accounts
         * @method GET
         */
        register_rest_route(
            RouteInterface::NAMESPACE . RouteInterface::VERSION,
            '/' . $this->base . '/social',
            [
                'methods'             => WP_REST_Server::READABLE, // Alias for GET transport method.
                'callback'            => [$this, 'get_social_settings'],
                'permission_callback' => Permission::PUBLIC->get_callback(),
            ]
        );

        /**
         * Route for fetching social accounts
         * @method GET
         */
        register_rest_route(
            RouteInterface::NAMESPACE . RouteInterface::VERSION,
            '/' . $this->base . '/social',
            [
                'methods'             => WP_REST_Server::EDITABLE, // Alias for POST transport method.
                'callback'            => [$this, 'update_social_settings'],
                'permission_callback' => Permission::ADMIN->get_callback(),
            ]
        );

        /**
         * Route for fetching analytics settings
         * @method GET
         */
        register_rest_route(
            RouteInterface::NAMESPACE . RouteInterface::VERSION,
            '/' . $this->base . '/analytics',
            [
                'methods'             => WP_REST_Server::READABLE, // Alias for GET transport method.
                'callback'            => [$this, 'get_analytics_settings'],
                'permission_callback' => Permission::PUBLIC->get_callback(),
            ]
        );

        /**
         * Route for updating analytics settings
         * @method POST
         */
        register_rest_route(
            RouteInterface::NAMESPACE . RouteInterface::VERSION,
            '/' . $this->base . '/analytics',
            [
                'methods'             => WP_REST_Server::EDITABLE, // Alias for POST transport method.
                'callback'            => [$this, 'update_analytics_settings'],
                'permission_callback' => Permission::ADMIN->get_callback(),
            ]
        );

        /**
         * Route for getting ChatGPT settings
         * @method GET
         */
        register_rest_route(
            RouteInterface::NAMESPACE . RouteInterface::VERSION,
            '/' . $this->base . '/chatgpt',
            [
                'methods'             => WP_REST_Server::READABLE, // Alias for GET transport method.
                'callback'            => [$this, 'get_chatgpt_settings'],
                'permission_callback' => Permission::PUBLIC->get_callback(),
            ]
        );

        /**
         * Route for updating ChatGPT settings
         * @method POST
         */
        register_rest_route(
            RouteInterface::NAMESPACE . RouteInterface::VERSION,
            '/' . $this->base . '/chatgpt',
            [
                'methods'             => WP_REST_Server::EDITABLE, // Alias for POST transport method.
                'callback'            => [$this, 'update_chatgpt_settings'],
                'permission_callback' => Permission::ADMIN->get_callback(),
            ]
        );

        /**
         * Route for purging transient cache
         * @method POST
         */
        register_rest_route(
            RouteInterface::NAMESPACE . RouteInterface::VERSION,
            '/' . $this->base . '/purge-cache',
            [
                'methods'             => WP_REST_Server::CREATABLE, // Alias for POST transport method.
                'callback'            => [$this, 'clean_transient_cache'],
                'permission_callback' => Permission::ADMIN->get_callback(),
            ]
        );

        /**
         * Route for getting theme custom logo
         * @method GET
         */
        register_rest_route(
            RouteInterface::NAMESPACE . RouteInterface::VERSION,
            '/' . $this->base . '/logo',
            [
                'methods'             => WP_REST_Server::READABLE, // Alias for GET transport method.
                'callback'            => [$this, 'get_custom_logo'],
                'permission_callback' => Permission::PUBLIC->get_callback(),
            ]
        );

        /**
         * Route for updating theme custom logo
         * @method POST
         */
        register_rest_route(
            RouteInterface::NAMESPACE . RouteInterface::VERSION,
            '/' . $this->base . '/logo',
            [
                'methods'             => WP_REST_Server::EDITABLE, // Alias for POST transport method.
                'callback'            => [$this, 'update_custom_logo'],
                'permission_callback' => Permission::ADMIN->get_callback(),
            ]
        );
    }

    /**
     * Get contact information
     * @param WP_REST_Request $request Request object
     * @return WP_REST_Response|WP_Error Response object
     */
    public function get_contact_settings(WP_REST_Request $request): WP_REST_Response|WP_Error {
        try {
            $result = OptionsUtils::get_contact_information();
        } catch (Exception $e) {
            return new WP_Error('error_' . $e->getCode(), $e->getMessage());
        }

        /**
         * Return WP REST Response
         */
        return new WP_REST_Response(
            [
                'status'  => 'success',
                'type'    => HTTP_Success::FETCHED_SUCCESSFULLY->get_type(),
                'message' => __('Fetched succesfully', 'Vihersalo-block-theme-core'),
                'data'    => $result,
            ],
            HTTP_Success::FETCHED_SUCCESSFULLY->get_http_status()
        );
    }

    /**
     * Update contact information
     * @param WP_REST_Request $request Request object
     * @return WP_REST_Response|WP_Error Response object
     * @throws Exception If user does not have sufficient permissions.
     */
    public function update_contact_settings(WP_REST_Request $request): WP_REST_Response|WP_Error {
        try {
            $result = OptionsUtils::update_contact_information($request);
        } catch (Exception $e) {
            return new WP_Error('error_' . $e->getCode(), $e->getMessage());
        }

        /**
         * Return WP REST Response
         */
        return new WP_REST_Response(
            [
                'status'  => 'success',
                'type'    => HTTP_Success::UPDATED_SUCCESSFULLY->get_type(),
                'message' => __('Updated succesfully', 'Vihersalo-block-theme-core'),
                'data'    => $result,
            ],
            HTTP_Success::UPDATED_SUCCESSFULLY->get_http_status()
        );
    }

    /**
     * Get social media settings
     * @return WP_REST_Response|WP_Error Response object
     */
    public function get_social_settings(): WP_REST_Response|WP_Error {
        try {
            $result = OptionsUtils::get_social_media_links();
        } catch (Exception $e) {
            return new WP_Error('error_' . $e->getCode(), $e->getMessage());
        }

        /**
         * Return WP REST Response
         */
        return new WP_REST_Response(
            [
                'status'  => 'success',
                'type'    => HTTP_Success::FETCHED_SUCCESSFULLY->get_type(),
                'message' => __('Fetched succesfully', 'Vihersalo-block-theme-core'),
                'data'    => $result,
            ],
            HTTP_Success::FETCHED_SUCCESSFULLY->get_http_status()
        );
    }

    /**
     * Update social media settings
     * @param WP_REST_Request $request Request object
     * @return WP_REST_Response|WP_Error Response object
     * @throws Exception If user does not have sufficient permissions.
     */
    public function update_social_settings(WP_REST_Request $request): WP_REST_Response|WP_Error {
        try {
            $result = OptionsUtils::update_social_media_links($request);
        } catch (Exception $e) {
            return new WP_Error('error_' . $e->getCode(), $e->getMessage());
        }

        /**
         * Return WP REST Response
         */
        return new WP_REST_Response(
            [
                'status'  => 'success',
                'type'    => HTTP_Success::UPDATED_SUCCESSFULLY->get_type(),
                'message' => __('Updated succesfully', 'Vihersalo-block-theme-core'),
                'data'    => $result,
            ],
            HTTP_Success::UPDATED_SUCCESSFULLY->get_http_status()
        );
    }

    /**
     * Get analytics settings
     * @return WP_REST_Response|WP_Error Response object
     */
    public function get_analytics_settings(): WP_REST_Response|WP_Error {
        try {
            $result = OptionsUtils::get_analytics_settings();
        } catch (Exception $e) {
            return new WP_Error('error_' . $e->getCode(), $e->getMessage());
        }

        /**
         * Return WP REST Response
         */
        return new WP_REST_Response(
            [
                'status'  => 'success',
                'type'    => HTTP_Success::FETCHED_SUCCESSFULLY->get_type(),
                'message' => __('Fetched succesfully', 'Vihersalo-block-theme-core'),
                'data'    => $result,
            ],
            HTTP_Success::FETCHED_SUCCESSFULLY->get_http_status()
        );
    }

    /**
     * Update analytics settings
     * @param WP_REST_Request $request Request object
     * @return WP_REST_Response|WP_Error Response object
     * @throws Exception If user does not have sufficient permissions.
     */
    public function update_analytics_settings(WP_REST_Request $request): WP_REST_Response|WP_Error {
        try {
            $result = OptionsUtils::update_analytics_settings($request);
        } catch (Exception $e) {
            return new WP_Error('error_' . $e->getCode(), $e->getMessage());
        }

        /**
         * Return WP REST Response
         */
        return new WP_REST_Response(
            [
                'status'  => 'success',
                'type'    => HTTP_Success::UPDATED_SUCCESSFULLY->get_type(),
                'message' => __('Updated succesfully', 'Vihersalo-block-theme-core'),
                'data'    => $result,
            ],
            HTTP_Success::UPDATED_SUCCESSFULLY->get_http_status()
        );
    }

    /**
     * Purge transient cache
     * @param WP_REST_Request $request Request object
     * @return WP_REST_Response|WP_Error Response object
     * @throws Exception If user does not have sufficient permissions.
     */
    public function clean_transient_cache(WP_REST_Request $request): WP_REST_Response|WP_Error {
        try {
            Utils::purgeTransientCache();
        } catch (Exception $e) {
            return new WP_Error('error_' . $e->getCode(), $e->getMessage());
        }

        /**
         * Return WP REST Response
         */
        return new WP_REST_Response(
            [
                'status'  => 'success',
                'type'    => HTTP_Success::CLEARED_SUCCESSFULLY->get_type(),
                'message' => __('Cache purged succesfully', 'Vihersalo-block-theme-core'),
            ],
            HTTP_Success::CLEARED_SUCCESSFULLY->get_http_status()
        );
    }

    /**
     * Get custom logo
     * @return WP_REST_Response|WP_Error Response object
     */
    public function get_custom_logo(): WP_REST_Response|WP_Error {
        try {
            $result = OptionsUtils::get_custom_logo();
        } catch (Exception $e) {
            return new WP_Error('error_' . $e->getCode(), $e->getMessage());
        }

        /**
         * Return WP REST Response
         */
        return new WP_REST_Response(
            [
                'status'  => 'success',
                'type'    => HTTP_Success::FETCHED_SUCCESSFULLY->get_type(),
                'message' => __('Fetched succesfully', 'Vihersalo-block-theme-core'),
                'data'    => $result,
            ],
            HTTP_Success::FETCHED_SUCCESSFULLY->get_http_status()
        );
    }

    /**
     * Update custom logo
     * @param WP_REST_Request $request Request object
     * @return WP_REST_Response|WP_Error Response object
     * @throws Exception If user does not have sufficient permissions.
     */
    public function update_custom_logo(WP_REST_Request $request): WP_REST_Response|WP_Error {
        try {
            $result = OptionsUtils::update_custom_logo($request);
        } catch (Exception $e) {
            return new WP_Error('error_' . $e->getCode(), $e->getMessage());
        }

        /**
         * Return WP REST Response
         */
        return new WP_REST_Response(
            [
                'status'  => 'success',
                'type'    => HTTP_Success::UPDATED_SUCCESSFULLY->get_type(),
                'message' => __('Updated succesfully', 'Vihersalo-block-theme-core'),
                'data'    => $result,
            ],
            HTTP_Success::UPDATED_SUCCESSFULLY->get_http_status()
        );
    }
}
