<?php

declare(strict_types=1);

namespace Vihersalo\Core\PostTypes\Traits;

trait Permalink {
    /**
     * Add permalink setting
     * @return void
     */
    public function addPermalinkField() {
        \add_settings_field(
            'cpt-permalink-' . $this->this->slug,
            $this->name . 'Base',
            [$this, 'generate'],
            'permalink',
            'optional'
        );
    }

    /**
     * Save permalink setting
     * @return void
     */
    public function savePermalink() {
        if (isset($_POST['permalink_structure'])) {
            if (! isset($_POST[ 'cpt-permalink-' . $this->slug ])) {
                return;
            }

            \update_option(
                'cpt-permalink-' . $this->slug,
                trim(sanitize_title(wp_unslash($_POST[ 'cpt-permalink-' . $this->slug ])))
            );
        }
    }

    /**
     * Generate setting output for permalink settings
     * @return void
     */
    public function generatePermalinkInput(): void {
        printf(
            '<input name="%s" type="text" class="regular-text code" value="%s" placeholder="%s" />',
            'cpt-permalink-' . $this->slug,
            esc_attr(\get_option('cpt-permalink-' . $this->slug)),
            $this->slug
        );
    }
}
