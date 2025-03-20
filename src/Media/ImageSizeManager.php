<?php
/**
 * Image class for handling image customizations
 *
 * @link       https://www.kotisivu.dev
 * @since      2.0.0
 *
 * @package    HeikkiVihersalo\BlockThemeCore\Theme
 */

namespace Vihersalo\BlockThemeCore\Media;

defined( 'ABSPATH' ) || die();

/**
 * Class for handling image customizations
 *
 * @since      2.0.0
 * @package    HeikkiVihersalo\BlockThemeCore\Theme
 * @author     Heikki Vihersalo <heikki@vihersalo.fi>
 */
class ImageSizeManager {
	/**
	 * Default image sizes
	 *
	 * @var array
	 */
	private array $default_image_sizes;

	/**
	 * Custom image sizes
	 *
	 * @var array
	 */
	private array $custom_image_sizes;

	/**
	 * Constructor
	 *
	 * @since    2.0.0
	 * @access   public
	 */
	public function __construct( array $default_image_sizes, array $custom_image_sizes ) {
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
			update_option( $size->get_width_option_name(), $size->get_width() );
			update_option( $size->get_height_option_name(), $size->get_height() );
		endforeach;

		/* Add new image sizes to core */
		foreach ( $this->custom_image_sizes as $size ) :
			add_image_size( $size->get_slug(), $size->get_width(), $size->get_height(), false );
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
			$custom_images[ $image->get_slug() ] = $image->get_name();
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
