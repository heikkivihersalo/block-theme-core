<?php

namespace Vihersalo\Core\Analytics;

use Vihersalo\Core\Support\Utils\Options as Utils;
/**
 *
 * @since      1.0.0
 * @package    Vihersalo\Core\Analytics
 * @author     Heikki Vihersalo <heikki@vihersalo.fi>
 */
class TagManager {
	/**
	 * Inline script for Google Tag Manager to be added to the head
	 *
	 * @since 1.0.0
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
}
