<?php

namespace Vihersalo\Core\PostTypes\Fields;

use Vihersalo\Core\Contracts\PostTypes\CustomField as CustomFieldContract;
use Vihersalo\Core\PostTypes\CustomField;

/**
 *
 *
 * @package Kotisivu\BlockTheme
 * @since 1.0.0
 */
class TextareaField extends CustomField implements CustomFieldContract {
    /**
     * @inheritDoc
     */
    public function getHTML(): string {
        ob_start();
        ?>

        <tr>
            <th scope="row">
                <label for="<?php echo $this->id; ?>"><?php echo $this->label; ?></label>
            </th>
            <td>
                <textarea 
                    rows="6" 
                    id="<?php echo $this->id; ?>" 
                    class="regular-text" 
                    name="<?php echo $this->id; ?>" 
                    value="<?php echo $this->getValue(); ?>"
                >
                    <?php echo $this->getValue(); ?>
                </textarea>
            </td>
        </tr>

        <?php
        return ob_get_clean();
    }

    /**
     * @inheritDoc
     */
    public function sanitize(string $value): string {
        return sanitize_textarea_field($value);
    }
}
