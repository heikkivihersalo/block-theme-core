<?php

declare(strict_types=1);

namespace Vihersalo\Core\Analytics;

use Vihersalo\Core\Support\Utils\Options as Utils;

class TagManager {
    /**
     * Inline script for Google Tag Manager to be added to the head
     * @return void
     */
    public function inlineTagManager(): void {
        $config = Utils::getOptionsFile('site-analytics');

        if (! $config || ! $config['tagmanager-active']) {
            return;
        }

        // phpcs:disable
        ?>
        <!-- Google Tag Manager -->
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
        <!-- End Google Tag Manager -->
        <?php
    }
}
