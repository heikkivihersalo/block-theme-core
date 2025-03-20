<?php
/**
 *
 * @link       https://www.kotisivu.dev
 * @since      2.0.0
 *
 * @package    Vihersalo\BlockThemeCore\Enqueue
 */

namespace Vihersalo\BlockThemeCore\Enqueue;

defined( 'ABSPATH' ) || die();

use Vihersalo\BlockThemeCore\Support\Notice;

/**
 *
 * @since      2.0.0
 * @package    Vihersalo\BlockThemeCore\Enqueue
 * @author     Heikki Vihersalo <heikki@vihersalo.fi>
 */
abstract class Asset {
	/**
	 * Constructor
	 *
	 * @param string $handle The handle of enqueued asset
	 * @param string $src The src of enqueued asset
	 * @param string $path The path of enqueued asset
	 * @param string $asset The asset file path
	 * @param int    $priority The priority of the enqueued asset
	 * @param bool   $admin Whether the asset is for admin or not
	 *
	 * @since 2.0.0
	 * @access private
	 * @return void
	 */
	public function __construct(
		private string $handle = '',
		private string $src = '',
		private string $path = '',
		private string $asset = '',
		private int $priority = 10,
		private bool $admin = false
	) {}

	/**
	 * Get the handle of enqueued asset
	 *
	 * @return string
	 */
	public function get_handle(): string {
		return $this->handle;
	}

	/**
	 * Get the URI of enqueued asset
	 *
	 * @return string
	 */
	public function get_src(): string {
		return $this->src;
	}

	/**
	 * Get the path of enqueued asset
	 *
	 * @return string
	 */
	public function get_path(): string {
		return $this->path;
	}

	/**
	 * Get the priority of enqueued asset
	 *
	 * @return int
	 */
	public function get_priority(): int {
		return $this->priority;
	}

	/**
	 * Get the admin boolean of enqueued asset
	 *
	 * @return bool
	 */
	public function is_admin(): bool {
		return $this->admin;
	}

	/**
	 * Get the asset file path
	 *
	 * @return string
	 */
	public function get_asset(): string {
		if ( '' === $this->asset ) :
			return '';
		endif;

		if ( ! $this->asset_exists() ) :
			return '';
		endif;

		return $this->asset;
	}

	/**
	 * Check if the asset exists
	 *
	 * @return bool
	 */
	public function asset_exists(): bool {
		if ( ! file_exists( SITE_PATH . '/' . $this->asset ) ) :
			$message = sprintf(
				/* translators: %1$s is the path to the asset */
				__( 'Asset in a path "%1$s" are missing. Run `yarn` and/or `yarn build` to generate them.', 'heikkivihersalo-block-theme-core' ),
				$this->asset
			);

			$notice = new Notice( $message );
			$notice->display();

			return false;
		endif;

		return true;
	}

	/**
	 * Register the asset
	 */
	abstract public function register(): void;
}
