<?php
/**
 *
 * @link       https://www.kotisivu.dev
 * @since      1.0.0
 *
 * @package    Vihersalo\Core\Support\Collections
 */

namespace Vihersalo\Core\Support\Collections;

defined( 'ABSPATH' ) || die();

use Vihersalo\Core\Enqueue\Asset;

/**
 * Collection of assets to be enqueued in the theme
 *
 * @since      1.0.0
 * @package    Vihersalo\Core\Support\Collections
 * @author     Heikki Vihersalo <heikki@vihersalo.fi>
 */
class AssetCollection {
	/**
	 * Array of assets to be enqueued in the theme
	 *
	 * @var array $assets The assets
	 */
	private $assets = [];

	/**
	 * Constructor
	 *
	 * @since 1.0.0
	 * @access private
	 * @return void
	 */
	public function __construct() {
	}

	/**
	 * Add new asset to the collection. Can be either a single asset or an array of assets.
	 *
	 * @param Asset|array $asset The asset or array of assets
	 * @return self
	 */
	public function add( $asset ) {
		if ( is_array( $asset ) ) {
			foreach ( $asset as $a ) {
				if ( $a instanceof Asset ) {
					$this->assets[] = $a;
				}
			}

			return $this;
		}

		if ( $asset instanceof Asset ) {
			$this->assets[] = $asset;
		}

		return $this;
	}

	/**
	 * Get the assets
	 *
	 * @return array The assets
	 */
	public function get(): array {
		return $this->assets;
	}
}
