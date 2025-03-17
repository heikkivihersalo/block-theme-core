<?php
/**
 * Meta tags
 *
 * @link       https://www.kotisivu.dev
 * @since      2.0.0
 *
 * @package    HeikkiVihersalo\BlockThemeCore\Theme
 */

namespace HeikkiVihersalo\BlockThemeCore\Theme;

defined( 'ABSPATH' ) || die();

use HeikkiVihersalo\BlockThemeCore\Theme\Common\Loader;
use HeikkiVihersalo\BlockThemeCore\Theme\Common\Traits\Options;
use HeikkiVihersalo\BlockThemeCore\Theme\Common\Utils\Options as Utils;
use HeikkiVihersalo\BlockThemeCore\Theme\Common\Traits\ThemeDefaults;
use HeikkiVihersalo\BlockThemeCore\Theme\Common\Interfaces\RegisterHooksInterface;

/**
 * Class for adding meta tags to the site head
 *
 * @since      2.0.0
 * @package    HeikkiVihersalo\BlockThemeCore\Theme
 * @author     Heikki Vihersalo <heikki@vihersalo.fi>
 */
class Meta implements RegisterHooksInterface {
	use ThemeDefaults;

	/**
	 * Constructor
	 *
	 * @since    2.0.0
	 * @access   public
	 */
	public function __construct( Loader $loader ) {
		$this->loader = $loader;
	}

	/**
	 * Inline sanitize CSS styles
	 *
	 * @since 2.0.0
	 * @access public
	 * @return void
	 */
	public function inline_sanitize_css(): void {
		$filesystem = new \WP_Filesystem_Direct( true );
		?>
		<style id="ksd-sanitize-inline-css">
			<?php echo $filesystem->get_contents( SITE_PATH . '/build/assets/sanitize.css' ); ?>
		</style>
		<?php
	}

	/**
	 * Inline CSS styles
	 *
	 * @since 2.0.0
	 * @access public
	 * @return void
	 */
	public function inline_custom_css(): void {
		$filesystem = new \WP_Filesystem_Direct( true );
		?>
		<style id="ksd-custom-inline-css">
			<?php echo $filesystem->get_contents( SITE_PATH . '/build/assets/inline.css' ); ?>
		</style>
		<?php
	}

	/**
	 * Inline theme color
	 *
	 * @since 2.0.0
	 * @access public
	 * @return void
	 */
	public function inline_theme_color(): void {
		?>
		<meta name="theme-color" content="<?php echo SITE_COLOR; ?>">
		<meta name="msapplication-navbutton-color" content="<?php echo SITE_COLOR; ?>">
		<meta name="apple-mobile-web-app-status-bar-style" content="<?php echo SITE_COLOR; ?>">
		<?php
	}

	/**
	 * Inline Google Tag Manager
	 *
	 * @since 2.0.0
	 * @access public
	 * @return void
	 */
	public function inline_tag_manager(): void {
		$config = Utils::get_options_file( 'site-analytics' );

		if ( ! $config || ! $config['tagmanager-active'] ) {
			return;
		}
		?>
		<script>
			var initGTMOnEvent = function(t) {
					initGTM(), t.currentTarget.removeEventListener(t.type, initGTMOnEvent)
				},
				initGTM = function() {
					if (window.gtmDidInit) return !1;
					window.gtmDidInit = !0;
					var t = document.createElement("script");
					t.type = "text/javascript", t.async = !0, t.onload = function() {
						dataLayer.push({
							event: "gtm.js",
							"gtm.start": (new Date).getTime(),
							"gtm.uniqueEventId": 0
						})
					}, t.src = "<?php echo $config['tagmanager-url']; ?>/gtm.js?id=<?php echo $config['tagmanager-id']; ?>", document.head.appendChild(t)
				};
			document.addEventListener("DOMContentLoaded", function() {
				setTimeout(initGTM, <?php echo $config['tagmanager-timeout']; ?>)
			}), document.addEventListener("scroll", initGTMOnEvent), document.addEventListener("mousemove", initGTMOnEvent), document.addEventListener("touchstart", initGTMOnEvent)
		</script>
		<?php
	}

	/**
	 * @inheritDoc
	 */
	public function register_hooks() {
		$this->loader->add_action( 'wp_head', $this, 'inline_sanitize_css', 0 );
		$this->loader->add_action( 'wp_head', $this, 'inline_theme_color', 0 );
		$this->loader->add_action( 'wp_head', $this, 'inline_tag_manager', 0 );
		$this->loader->add_action( 'wp_head', $this, 'inline_custom_css', 11 );
	}
}
