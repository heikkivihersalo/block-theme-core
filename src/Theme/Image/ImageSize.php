<?php
/**
 *
 * @link       https://www.kotisivu.dev
 * @since      2.0.0
 *
 * @package    HeikkiVihersalo\BlockThemeCore\Theme\Image
 */

namespace HeikkiVihersalo\BlockThemeCore\Theme\Image;

defined( 'ABSPATH' ) || die();

/**
 *
 * @since      2.0.0
 * @package    HeikkiVihersalo\BlockThemeCore\Theme\Image
 * @author     Heikki Vihersalo <heikki@vihersalo.fi>
 */
class ImageSize {
	/**
	 * Constructor
	 *
	 * @param string $slug The slug of the menu
	 * @param string $name The name of the menu
	 * @since 2.0.0
	 * @access private
	 * @return void
	 */
	public function __construct( private string $slug, private string $name, private int $width, private int $height ) {
	}

	public static function create( string $slug, string $name, int $width, int $height ): self {
		return new self( $slug, $name, $width, $height );
	}
	/**
	 * Get the slug of the menu
	 *
	 * @return string
	 */
	public function get_slug(): string {
		return $this->slug;
	}

	/**
	 * Get the name of the menu
	 *
	 * @return string
	 */
	public function get_name(): string {
		return $this->name;
	}

	/**
	 * Get the width of the image
	 *
	 * @return int
	 */
	public function get_width(): int {
		return $this->width;
	}

	/**
	 * Get the height of the image
	 *
	 * @return int
	 */
	public function get_height(): int {
		return $this->height;
	}
}
