<?php
/**
 * Custom REST field
 *
 * @link       https://www.kotisivu.dev
 * @since      1.0.0
 *
 * @package    Vihersalo\Core\Common
 */

namespace Vihersalo\Core\Theme\Api\Traits;

/**
 * Custom REST field
 *
 * @since      1.0.0
 * @package    Vihersalo\Core\Common
 * @author     Heikki Vihersalo <heikki@vihersalo.fi>
 */
trait CustomRestField {
	/**
	 * Register custom REST field
	 *
	 * @param string   $type The type of the field
	 * @param string   $field The field name
	 * @param callable $callback The callback function
	 * @return void
	 */
	public function register_custom_rest_field( string $type, string $field, callable $callback ): void {
		register_rest_field(
			$type,
			$field,
			[
				'get_callback' => $callback,
			]
		);
	}
}
