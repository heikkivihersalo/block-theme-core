<?php

namespace Vihersalo\BlockThemeCore\Support\Assets;

use Vihersalo\BlockThemeCore\Application\HooksLoader;
use Vihersalo\BlockThemeCore\Enqueue\Asset;

/**
 * The script asset class
 *
 * @since      2.0.0
 * @package    Vihersalo\BlockThemeCore\Support\Assets
 * @author     Heikki Vihersalo <heikki@vihersalo.fi>
 */
class Style extends Asset {
	/**
	 * Create a new style asset
	 *
	 * @param string $handle The handle of enqueued asset
	 * @param string $src The src of enqueued asset
	 * @param string $asset The asset file path
	 * @param int    $priority The priority of the enqueued asset
	 * @param bool   $admin Whether the asset is for admin or not
	 * @param bool   $editor Whether the asset is for `add_editor_style` function or not
	 * @return self
	 */
	public static function create( string $handle, string $src, string $asset, int $priority = 10, bool $admin = false, bool $editor = false ): self {
		return new self( $handle, $src, '', $asset, $priority, $admin, $editor );
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

		wp_enqueue_style(
			$this->get_handle(),
			$this->app->make( 'config' )->get( 'uri' ) . '/' . $this->get_src(),
			array(),
			$assets['version'],
			'all'
		);
	}

	/**
	 * Register the script
	 *
	 * @return void
	 */
	public function register(): void {
		$action = $this->is_admin() ? 'admin_enqueue_scripts' : 'wp_enqueue_scripts';

		if ( $this->is_editor() ) {
			$this->loader->add_action( 'admin_init', $this, 'add_to_editor_styles' );
		}

		$this->app->make( HooksLoader::class )->add_action( $action, $this, 'enqueue', $this->get_priority() );
	}
}
