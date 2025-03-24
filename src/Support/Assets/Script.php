<?php

namespace Vihersalo\Core\Support\Assets;

use Vihersalo\Core\Application\HooksLoader;
use Vihersalo\Core\Enqueue\Asset;

/**
 * The script asset class
 *
 * @since      1.0.0
 * @package    Vihersalo\Core\Support\Assets
 * @author     Heikki Vihersalo <heikki@vihersalo.fi>
 */
class Script extends Asset {
	/**
	 * Create a new script asset instance
	 *
	 * @param string $handle The handle of enqueued asset
	 * @param string $src The URI of enqueued asset
	 * @param string $asset The asset file path
	 * @param int    $priority The priority of the enqueued asset
	 * @param bool   $admin Whether the asset is for admin or not
	 * @return self
	 */
	public static function create( string $handle, string $src, string $asset, int $priority = 10, bool $admin = false ): self {
		return new self( $handle, $src, '', $asset, $priority, $admin );
	}

	/**
	 * Enqueue the script
	 *
	 * @return void
	 */
	public function enqueue() {
		$asset_path = $this->get_asset_path();

		if ( '' === $asset_path ) {
			return;
		}

		$assets = require $this->app->make( 'config' )->get( 'app.path' ) . '/' . $asset_path;

		wp_enqueue_script(
			$this->get_handle(),
			$this->app->make( 'config' )->get( 'uri' ) . '/' . $this->get_src(),
			$assets['dependencies'],
			$assets['version'],
			true
		);
	}

	/**
	 * Register the script
	 *
	 * @return void
	 */
	public function register(): void {
		$action = $this->is_admin() ? 'admin_enqueue_scripts' : 'wp_enqueue_scripts';
		$this->app->make( HooksLoader::class )->add_action( $action, $this, 'enqueue', $this->get_priority() );
	}
}
