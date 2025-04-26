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
class SelectField extends CustomField implements CustomFieldContract {
    /**
     * @inheritDoc
     */
    public function getHTML(): string {
        if (empty($this->id)) {
            return __('ID is required', 'heikkivihersalo-custom-post-types');
        }

        ob_start();
        ?>

        <tr>
            <th scope="row">
                <label for="<?php echo $this->id; ?>">
                    <?php echo $this->getLabel(); ?>
                </label>
            </th>
            <td>
                <select name="<?php echo $this->id; ?>" id="<?php echo $this->id; ?>">
                    <?php foreach ($this->options as $key => $label) : ?>
                        <option 
                            value="<?php echo $key; ?>" 
                            <?php echo selected($this->getValue(), $key); ?>
                        >
                            <?php echo $label; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </td>
        </tr>

        <?php
        return ob_get_clean();
    }

    /**
     * @inheritDoc
     */
    public function sanitize(string $value): string {
        return sanitize_text_field($value);
    }
}
