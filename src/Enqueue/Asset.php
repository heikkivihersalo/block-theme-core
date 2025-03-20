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

use Vihersalo\BlockThemeCore\Application;
use Vihersalo\BlockThemeCore\Support\Notice;

/**
 *
 * @since      2.0.0
 * @package    Vihersalo\BlockThemeCore\Enqueue
 * @author     Heikki Vihersalo <heikki@vihersalo.fi>
 */
abstract class Asset {
	/**
	 * App instance
	 * @var Application
	 */
	protected $app;

	/**
	 * The handle of enqueued asset
	 * @var string
	 */
	protected $handle;

	/**
	 * The src of enqueued asset
	 * @var string
	 */
	protected $src;

	/**
	 * The path of enqueued asset
	 * @var string
	 */
	protected $path;

	/**
	 * The asset file path
	 * @var string
	 */
	protected $asset;

	/**
	 * The priority of the enqueued asset
	 * @var int
	 */
	protected $priority;

	/**
	 * Whether the asset is for admin or not
	 * @var bool
	 */
	protected $admin;

	/**
	 * Whether the asset is for `add_editor_style` function or not
	 * @var bool
	 */
	protected $editor;

	/**
	 * Constructor
	 *
	 * @param string $handle The handle of enqueued asset
	 * @param string $src The src of enqueued asset
	 * @param string $path The path of enqueued asset
	 * @param string $asset The asset file path
	 * @param int    $priority The priority of the enqueued asset
	 * @param bool   $admin Whether the asset is for admin or not
	 * @param bool   $editor Whether the asset is for `add_editor_style` function or not
	 *
	 * @since 2.0.0
	 * @access private
	 * @return void
	 */
	public function __construct(
		string $handle = '',
		string $src = '',
		string $path = '',
		string $asset = '',
		int $priority = 10,
		bool $admin = false,
		bool $editor = false
	) {
		$this->handle   = $handle;
		$this->src      = $src;
		$this->path     = $path;
		$this->asset    = $asset;
		$this->priority = $priority;
		$this->admin    = $admin;
		$this->editor   = $editor;
		$this->app      = Application::getInstance();
	}

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
	 * Get the editor boolean of enqueued asset
	 *
	 * @return bool
	 */
	public function is_editor(): bool {
		return $this->editor;
	}

	/**
	 * Get the asset file path
	 *
	 * @return string
	 */
	public function get_asset_path(): string {
		if ( '' === $this->asset ) :
			return '';
		endif;

		if ( ! $this->asset_exists() ) :
			return '';
		endif;

		return $this->asset;
	}

	/**
	 * Enqueue the asset in the admin
	 *
	 * @return void
	 */
	public function add_to_editor_styles() {
		add_editor_style( $this->app->make( 'config' )->get( 'uri' ) . '/' . $this->get_src() );
	}

	/**
	 * Check if the asset exists
	 *
	 * @return bool
	 */
	public function asset_exists(): bool {
		$path = $this->app->make( 'config' )->get( 'app.path' );

		if ( ! file_exists( trailingslashit( $path ) . $this->asset ) ) :
			$message = sprintf(
				/* translators: %1$s is the path to the asset */
				__( 'Asset in a path "%1$s" are missing. Run `yarn` and/or `yarn build` to generate them.', 'vihersalo-block-theme-core' ),
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
