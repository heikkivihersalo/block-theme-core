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
            'cpt-permalink-' . parent::getSlug(),
            parent::getName() . ' Base',
            function () {
                printf(
                    '<input name="%s" type="text" class="regular-text code" value="%s" placeholder="%s" />',
                    'cpt-permalink-' . parent::getSlug(),
                    esc_attr(\get_option('cpt-permalink-' . parent::getSlug())),
                    parent::getSlug()
                );
            },
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
            if (! isset($_POST[ 'cpt-permalink-' . parent::getSlug() ])) {
                return;
            }

            \update_option(
                'cpt-permalink-' . parent::getSlug(),
                trim(sanitize_title(wp_unslash($_POST[ 'cpt-permalink-' . parent::getSlug() ])))
            );
        }
    }
}
