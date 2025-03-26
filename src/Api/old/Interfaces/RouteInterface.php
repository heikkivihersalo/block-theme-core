<?php
/**
 * Route Interface
 *
 * @link       https://www.kotisivu.dev
 * @since      1.0.0
 *
 * @package    Vihersalo\Core\Theme\Api\Interfaces\RouteInterface
 */

namespace Vihersalo\Core\Theme\Api\Interfaces;

defined( 'ABSPATH' ) || die();

/**
 * Route Interface
 *
 * @since      1.0.0
 * @package    Vihersalo\Core\Theme\Api\Interfaces\RouteInterface
 * @author     Heikki Vihersalo <heikki@vihersalo.fi>
 */
interface RouteInterface {
	const VERSION   = '1';
	const NAMESPACE = 'Vihersalo-block-theme-core/v';

	/**
	 * Register default CRUD endpoints
	 *
	 * @return void
	 */
	public function register_crud_endpoints(): void;

	/**
	 * Get all items from database
	 *
	 * @param \WP_REST_Request $request Request object
	 * @return \WP_REST_Response|WP_Error Response object
	 */
	public function get_all_items( \WP_REST_Request $request ): \WP_REST_Response|\WP_Error;

	/**
	 * Get item by id
	 *
	 * @param \WP_REST_Request $request Request object
	 * @return \WP_REST_Response|WP_Error Response object
	 */
	public function get_item_by_id( \WP_REST_Request $request ): \WP_REST_Response|\WP_Error;

	/**
	 * Create item
	 *
	 * @param \WP_REST_Request $request Request object
	 * @return \WP_REST_Response|WP_Error Response object
	 */
	public function create_item( \WP_REST_Request $request ): \WP_REST_Response|\WP_Error;

	/**
	 * Update item
	 *
	 * @param \WP_REST_Request $request Request object
	 * @return \WP_REST_Response|WP_Error Response object
	 */
	public function update_item( \WP_REST_Request $request ): \WP_REST_Response|\WP_Error;

	/**
	 * Delete item
	 *
	 * @param \WP_REST_Request $request Request object
	 * @return \WP_REST_Response|WP_Error Response object
	 */
	public function delete_item( \WP_REST_Request $request ): \WP_REST_Response|\WP_Error;
}
