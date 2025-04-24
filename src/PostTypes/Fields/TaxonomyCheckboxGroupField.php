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
class TaxonomyCheckboxGroupField extends CustomField implements CustomFieldContract {
    /**
     * @inheritDoc
     */
    public function getHTML(): string {
        if (empty($this->id)) {
            return __('ID is required', 'heikkivihersalo-custom-post-types');
        }

        if (empty($this->taxonomy)) {
            return __('Taxonomy is required', 'heikkivihersalo-custom-post-types');
        }

        $terms = get_terms(
            [
                'taxonomy'   => $this->taxonomy,
                'hide_empty' => false, // Retrieve all terms
            ]
        );

        $selected = get_the_terms(get_the_ID(), $this->taxonomy);

        ob_start();
        ?>

        <tr>
            <th scope="row">
                <label for="<?php echo $this->taxonomy; ?>"><?php echo $this->getLabel(); ?></label>
            </th>
            <td>
                <fieldset>
                    <legend class="screen-reader-text">
                        <span><?php echo $this->getLabel(); ?></span>
                    </legend>
                    <?php if (! $terms) : ?>
                        <p><?php _e('No options', 'heikkivihersalo-custom-post-types'); ?></p>
                    <?php else : ?>
                        <?php foreach ($terms as $term) : ?>
                            <label for="<?php echo $term->slug; ?>">
                                <input 
                                    id="<?php echo $term->slug; ?>" 
                                    type="checkbox" 
                                    class="regular-text" 
                                    name="tax_input[<?php echo $this->taxonomy; ?>][]" 
                                    value="<?php echo $term->term_id; ?>" 
                                    <?php echo $this->isTermChecked($term->term_id, $selected); ?>
                                >
                                <?php echo $term->name; ?>
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
        if (empty($this->taxonomy)) {
            return;
        }

        if (isset($_POST['tax_input'][ $this->taxonomy ])) {
            $term_ids = array_map('intval', $_POST['tax_input'][ $this->taxonomy ]);
            wp_set_object_terms($post_id, $term_ids, $this->taxonomy);
        } else {
            wp_set_object_terms($post_id, [], $this->taxonomy);
        }
    }
}
