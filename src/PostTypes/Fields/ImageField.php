<?php

declare(strict_types=1);

namespace Vihersalo\Core\PostTypes\Fields;

use Vihersalo\Core\Contracts\PostTypes\CustomField as CustomFieldContract;
use Vihersalo\Core\PostTypes\CustomField;
use Vihersalo\Core\PostTypes\Fields\Markup\ImageMarkup;

class ImageField extends CustomField implements CustomFieldContract {
    /**
     * @inheritDoc
     */
    public function getHTML(): string {
        $html = new ImageMarkup(
            $this->id,
            $this->label,
            $this->getValue(),
            wp_get_attachment_image_src(get_post_meta($this->post->ID, $this->id, true), 'full')
        );

        return $html->markup();
    }
}
