<?php
/**
 * Class for handling excerpt customizations
 *
 * @link       https://www.kotisivu.dev
 * @since      1.0.0
 *
 * @package    Vihersalo\Core\Theme
 */

namespace Vihersalo\Core\Media;

defined( 'ABSPATH' ) || die();

/**
 * Class for handling excerpt customizations
 *
 * @since      1.0.0
 * @package    Vihersalo\Core\Theme
 * @author     Heikki Vihersalo <heikki@vihersalo.fi>
 */
class ExcerptManager {
	/**
	 * @var string|int
	 */
	private $length;

	/**
	 * @var string
	 */
	private $more;

	/**
	 * Constructor
	 *
	 * @since    1.0.0
	 * @access   public
	 */
	public function __construct( string|int $length, string $more ) {
		$this->length = $length;
		$this->more   = $more;
	}

	/**
	 * Override default excerpt length
	 *
	 * @return int
	 */
	public function custom_excerpt_length(): int {
		if ( ! isset( $this->length ) ) {
			return 55;
		}

		// check that is integer
		if ( is_int( $this->length ) ) {
			return $this->length;
		}

		// Check that is string and convert to integer
		if ( is_string( $this->length ) ) {
			return (int) $this->length;
		}

		return 55;
	}

	/**
	 * Override default excerpt more
	 *
	 * @return string
	 */
	public function custom_excerpt_more(): string {
		if ( ! isset( $this->more ) ) {
			return '&hellip;';
		}

		// check that is string
		if ( is_string( $this->more ) ) {
			return $this->more;
		}

		return '&hellip;';
	}
}
