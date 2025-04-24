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
class CheckboxGroupField extends CustomField implements CustomFieldContract {
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
                <label for="<?php echo $this->id; ?>"><?php echo $this->getLabel(); ?></label>
            </th>
            <td>
                <fieldset>
                    <legend class="screen-reader-text">
                        <span><?php echo $this->getLabel(); ?></span>
                    </legend>
                    <?php if (! $this->options) : ?>
                        <p><?php _e('No options', 'heikkivihersalo-custom-post-types'); ?></p>
                    <?php else : ?>
                        <?php foreach ($this->options as $option) : ?>
                            <label for="<?php echo $this->id . '_' . $option['value']; ?>">
                                <input 
                                    id="<?php echo $this->id . '_' . $option['value']; ?>" 
                                    type="checkbox" 
                                    class="regular-text" 
                                    name="<?php echo $this->id . '_' . $option['value']; ?>" 
                                    value="1" <?php checked(1, get_post_meta($this->post->ID, $this->id . '_' . $option['value'], true)); ?> <?php // phpcs:ignore?>
                                >
                                <?php echo $option['label']; ?>
                            </label>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </fieldset>
            </td>
        </tr>

        <?php
        return ob_get_clean();
    }

    /**
     * @inheritDoc
     */
    public function save(int $post_id, array $options = []): void {
        foreach ($options as $option) {
            // Nonce verification is done in the parent class so we can safely ignore it here.
            if (isset($_POST[ $this->id . '_' . $option['value'] ])) {
                update_post_meta($post_id, $this->id . '_' . $option['value'], '1');
            } else {
                delete_post_meta($post_id, $this->id . '_' . $option['value']);
            }
        }
    }
}
