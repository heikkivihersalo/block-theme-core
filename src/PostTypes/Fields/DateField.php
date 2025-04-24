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
class DateField extends CustomField implements CustomFieldContract {
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
                <input 
                    id="<?php echo $this->id; ?>" 
                    type="date" 
                    class="regular-text" 
                    name="<?php echo $this->id; ?>" 
                    value="<?php echo $this->getValue(); ?>"
                >
            </td>
        </tr>

        <?php
        return ob_get_clean();
    }
}
