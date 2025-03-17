<?php
/**
 * Image class for handling image customizations
 *
 * @link       https://www.kotisivu.dev
 * @since      2.0.0
 *
 * @package    HeikkiVihersalo\BlockThemeCore\Theme
 */

namespace HeikkiVihersalo\BlockThemeCore\Theme;

defined( 'ABSPATH' ) || die();

use HeikkiVihersalo\BlockThemeCore\Theme\Common\Loader;
use HeikkiVihersalo\BlockThemeCore\Theme\Common\Traits\ThemeDefaults;
use HeikkiVihersalo\BlockThemeCore\Theme\Common\Interfaces\RegisterHooksInterface;
use HeikkiVihersalo\BlockThemeCore\Theme\Common\Models\ImageSize;

/**
 * Class for handling image customizations
 *
 * @since      2.0.0
 * @package    HeikkiVihersalo\BlockThemeCore\Theme
 * @author     Heikki Vihersalo <heikki@vihersalo.fi>
 */
class Image implements RegisterHooksInterface {
	use ThemeDefaults;

	/**
	 * Constructor
	 *
	 * @since    2.0.0
	 * @access   public
	 */
	public function __construct( Loader $loader, array $default_image_sizes, array $custom_image_sizes ) {
		$this->loader              = $loader;
		$this->default_image_sizes = $default_image_sizes;
		$this->custom_image_sizes  = $custom_image_sizes;
	}

	/**
	 * Add custom image options for WordPress
	 *
	 * @param mixed $sizes Image sizes
	 * @return void
	 */
	public function register_image_sizes(): void {
		/* Update default core image sizes */
		foreach ( $this->default_image_sizes as $size ) :
			update_option( $size['slug'] . '_size_w', $size['width'] );
			update_option( $size['slug'] . '_size_h', $size['height'] );
		endforeach;

		/* Add new image sizes to core */
		foreach ( $this->custom_image_sizes as $size ) :
			add_image_size( $size['slug'], $size['width'], $size['height'], false );
		endforeach;
	}

	/**
	 * Remove default image sizes from WordPress
	 *
	 * @param mixed $sizes Image sizes
	 * @return mixed
	 */
	public function remove_default_image_sizes( mixed $sizes ): mixed {
		unset( $sizes['1536x1536'] ); // remove 1536x1536 image size
		unset( $sizes['2048x2048'] ); // remove 2048x2048 image size

		return $sizes;
	}

	/**
	 * Add custom image options to admin interface
	 *
	 * @param mixed $sizes Image sizes
	 * @return array
	 */
	public function add_custom_image_sizes_to_admin( mixed $sizes ): array {
		$custom_images = array();

		foreach ( $this->custom_image_sizes as $image ) :
			$custom_images[ $image['slug'] ] = $image['name'];
		endforeach;

		return array_merge( $sizes, $custom_images );
	}

	/**
	 * @inheritDoc
	 */
	public function register_hooks() {
		$this->loader->add_action( 'after_setup_theme', $this, 'register_image_sizes' );
		$this->loader->add_filter( 'intermediate_image_sizes', $this, 'remove_default_image_sizes' );
		$this->loader->add_filter( 'image_size_names_choose', $this, 'add_custom_image_sizes_to_admin' );
	}
}
