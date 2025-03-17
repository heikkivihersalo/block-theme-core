<?php
/**
 * The enqueue scripts class.
 *
 * @link       https://www.kotisivu.dev
 * @since      2.0.0
 *
 * @package    HeikkiVihersalo\BlockThemeCore\Common
 */

namespace HeikkiVihersalo\BlockThemeCore\Theme\Common;

defined( 'ABSPATH' ) || die();

use HeikkiVihersalo\BlockThemeCore\Theme\Common\Interfaces\EnqueueInterface;

/**
 * The enqueued scripts functionality of the plugin.
 *
 * @since      2.0.0
 * @package    HeikkiVihersalo\BlockThemeCore\Common
 * @author     Heikki Vihersalo <heikki@vihersalo.fi>
 */
abstract class Enqueue implements EnqueueInterface {
	/**
	 * Handle for registering scripts and styles.
	 *
	 * @var string
	 */
	protected static $handle = '';

	/**
	 * Path to the script file.
	 *
	 * @var string
	 */
	protected static $script_uri = '';

	/**
	 * Path to the style file.
	 *
	 * @var string
	 */
	protected static $style_uri = '';

	/**
	 * Path to the asset file.
	 *
	 * @var string
	 */
	protected static $asset_path = '';

	/**
	 * Constructor
	 *
	 * @since    2.0.0
	 * @access   public
	 */
	public function __construct() {
	}

	/**
	 * @inheritDoc
	 */
	public static function asset_exists( string $path, string $type = '' ): bool {
		if ( ! file_exists( SITE_PATH . '/' . $path ) ) :
			$message = sprintf(
				/* translators: %1$s is the type of the asset, %2$s is the path to the asset */
				__( 'Plugin%1$s assets in a path "%2$s" are missing. Run `yarn` and/or `yarn build` to generate them.', 'heikkivihersalo-block-theme-core' ),
				$type ? ' ' . $type : '',
				$path
			);

			$notice = new Notice( $message );
			$notice->display();

			return false;
		endif;

		return true;
	}

	/**
	 * @inheritDoc
	 */
	public static function enqueue_style(): void {
		if ( '' === static::$style_uri ) {
			return;
		}

		if ( ! self::asset_exists( static::$asset_path ) ) {
			return;
		}

		$assets = include SITE_PATH . '/' . static::$asset_path;
		wp_enqueue_style( static::$handle, SITE_URI . '/' . static::$style_uri, array(), $assets['version'], 'all' );
	}

	/**
	 * @inheritDoc
	 */
	public static function enqueue_script(): void {
		if ( '' === static::$script_uri ) {
			return;
		}

		if ( ! self::asset_exists( static::$asset_path ) ) {
			return;
		}

		$assets = include SITE_PATH . '/' . static::$asset_path;
		wp_enqueue_script( static::$handle, SITE_URI . '/' . static::$script_uri, $assets['dependencies'], $assets['version'], true );
	}

	/**
	 * @inheritDoc
	 */
	public static function register(): void {
		self::enqueue_style();
		self::enqueue_script();
	}
}
