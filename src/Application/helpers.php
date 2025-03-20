<?php
/**
 * Helper functions for the application
 *
 * To prevent conflicts with other packages like WordPress, the functions are namespaced
 * You can use these functions in your theme or plugin by calling the namespace
 *
 * @link https://github.com/laravel/framework/blob/12.x/src/Illuminate/Foundation/helpers.php
 */

namespace Vihersalo\BlockThemeCore\Application {
	use Vihersalo\BlockThemeCore\Application;
	use Illuminate\Container\Container;

	if ( ! function_exists( 'app' ) ) {
		/**
		 * Get the available container instance.
		 *
		 * @template TClass of object
		 *
		 * @param  string|class-string<TClass>|null $abstract
		 * @param  array                            $parameters
		 * @return ($abstract is class-string<TClass> ? TClass : ($abstract is null ? \Illuminate\Foundation\Application : mixed))
		 */
		function app( $abstract = null, array $parameters = array() ) {
			if ( is_null( $abstract ) ) {
				return Container::getInstance();
			}

			return Container::getInstance()->make( $abstract, $parameters );
		}
	}

	if ( ! function_exists( 'config' ) ) {
		/**
		 * Get / set the specified configuration value.
		 *
		 * If an array is passed as the key, we will assume you want to set an array of values.
		 *
		 * @param  array<string, mixed>|string|null $key
		 * @param  mixed                            $default
		 * @return ($key is null ? \Illuminate\Config\Repository : ($key is string ? mixed : null))
		 */
		function config( $key = null, $default = null ) {
			if ( is_null( $key ) ) {
				return app( 'config' );
			}

			if ( is_array( $key ) ) {
				return app( 'config' )->set( $key );
			}

			return app( 'config' )->get( $key, $default );
		}
	}

	if ( ! function_exists( 'wp_loader' ) ) {
		/**
		 * Get the hooks loader instance
		 *
		 * @return \Vihersalo\BlockThemeCore\Application\HooksLoader
		 */
		function wp_loader() {
			return app( HooksLoader::class );
		}
	}
}
