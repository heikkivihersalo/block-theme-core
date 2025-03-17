<?php
/**
 * Functions for enqueuing scripts and styles
 *
 * @link       https://www.kotisivu.dev
 * @since      2.0.0
 *
 * @package    HeikkiVihersalo\BlockThemeCore\Theme
 */

namespace HeikkiVihersalo\BlockThemeCore\Theme;

defined( 'ABSPATH' ) || die();

use WP_Filesystem_Direct;

use HeikkiVihersalo\BlockThemeCore\Theme\Common\Loader;
use HeikkiVihersalo\BlockThemeCore\Theme\Common\Enqueue as CommonEnqueue;
use HeikkiVihersalo\BlockThemeCore\Theme\Common\Interfaces\EnqueueInterface;
use HeikkiVihersalo\BlockThemeCore\Theme\Common\Interfaces\RegisterHooksInterface;
use HeikkiVihersalo\BlockThemeCore\Theme\Common\Traits\ThemeDefaults;

/**
 * Functions for enqueuing scripts and styles
 *
 * @since      2.0.0
 * @package    HeikkiVihersalo\BlockThemeCore\Theme
 * @author     Heikki Vihersalo <heikki@vihersalo.fi>
 */
class Enqueue extends CommonEnqueue implements EnqueueInterface, RegisterHooksInterface {
	use ThemeDefaults;

	/**
	 * @var array
	 */
	private array $enqueue;

	/**
	 * @var string
	 */
	private string $base;

	/**
	 * Constructor
	 *
	 * @since    2.0.0
	 * @access   public
	 */
	public function __construct( Loader $loader, array $enqueue ) {
		$this->loader  = $loader;
		$this->enqueue = $enqueue;
		$this->base    = isset( $enqueue['base'] ) ? $enqueue['base'] : 'build';
	}

	/**
	 * Run the editor scripts and styles
	 *
	 * @since    2.0.0
	 * @access public
	 * @param string $hook The current admin page
	 * @return void
	 */
	public function enqueue_scripts_and_styles( string $hook = '' ): void {
		if ( ! isset( $this->enqueue['scripts'] ) ) {
			return;
		}

		foreach ( $this->enqueue['scripts'] as $script ) {
			$asset_path = SITE_PATH . '/' . $this->base . '/' . $script['asset_path'];
			$src        = SITE_URI . '/' . $this->base . '/' . $script['src'];

			$this->enqueue_script( $asset_path, $src, 'ksd-theme' );
		}

		if ( ! isset( $this->enqueue['styles'] ) ) {
			return;
		}

		foreach ( $this->enqueue['styles'] as $style ) {
			$asset_path = SITE_PATH . '/' . $this->base . '/' . $style['asset_path'];
			$src        = SITE_URI . '/' . $this->base . '/' . $style['src'];

			$this->enqueue_style( $asset_path, $src, 'ksd-theme' );
		}
	}

	/**
	 * Print inline styles
	 *
	 * @since    2.0.0
	 * @access public
	 * @return void
	 */
	public function inline_sanitize_css(): void {
		if ( ! isset( $this->enqueue['sanitize'] ) ) {
			return;
		}

		$filesystem = new WP_Filesystem_Direct( true );
		$id         = SITE_PATH . '/' . $this->base . '/' . $this->enqueue['sanitize']['css']['id'];
		$path       = SITE_PATH . '/' . $this->base . '/' . $this->enqueue['sanitize']['css']['src'];

		if ( ! $filesystem->exists( $path ) ) {
			return;
		}

		?>
		<style id="<?php echo esc_attr( $id ); ?>">
			<?php echo $filesystem->get_contents( $path ); ?>
		</style>
		<?php
	}

	/**
	 * Print inline styles
	 *
	 * @since    2.0.0
	 * @access public
	 * @return void
	 */
	public function inline_custom_css(): void {
		if ( ! isset( $this->enqueue['inline'] ) ) {
			return;
		}

		$filesystem = new WP_Filesystem_Direct( true );
		$id         = SITE_PATH . '/' . $this->base . '/' . $this->enqueue['inline']['css']['id'];
		$path       = SITE_PATH . '/' . $this->base . '/' . $this->enqueue['inline']['css']['src'];

		if ( ! $filesystem->exists( $path ) ) {
			return;
		}

		?>
		<style id="<?php echo esc_attr( $id ); ?>">
			<?php echo $filesystem->get_contents( $path ); ?>
		</style>
		<?php
	}

	/**
	 * Move global styles to top of print styles
	 * - This is to ensure that global styles are loaded first
	 * - This is important so we can override the global styles with local styles if needed
	 * @since 2.0.0
	 * @access public
	 * @param array $styles Print styles array
	 * @return array Modified print styles array
	 */
	public function move_global_styles_to_top( $styles ): array {
		if ( ! is_array( $styles ) ) {
			return $styles;
		}

		$total = count( $styles );

		for ( $i = 0; $i < $total; $i++ ) {
			if ( isset( $styles[ $i ] ) && 'global-styles' === $styles[ $i ] ) {
				unset( $styles[ $i ] );
				array_unshift( $styles, 'global-styles' );
				break;
			}
		}

		return $styles;
	}

	/**
	 * @inheritDoc
	 */
	public function register_hooks() {
		$this->loader->add_action( 'wp_enqueue_scripts', $this, 'enqueue_scripts_and_styles' );
		$this->loader->add_filter( 'print_styles_array', $this, 'move_global_styles_to_top', 10, 1 );

		// Handle inline scripts and styles
		if ( isset( $this->enqueue['sanitize']['enabled'] ) && $this->enqueue['sanitize']['enabled'] ) {
			$this->loader->add_action( 'wp_head', $this, 'inline_sanitize_css', $this->enqueue['sanitize']['css']['priority'] );
		}

		if ( isset( $this->enqueue['inline']['enabled'] ) && $this->enqueue['inline']['enabled'] ) {
			$this->loader->add_action( 'wp_head', $this, 'inline_custom_css', $this->enqueue['inline']['css']['priority'] );
		}
	}
}
