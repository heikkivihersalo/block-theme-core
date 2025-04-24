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
class ImageField extends CustomField implements CustomFieldContract {
    /**
     * @inheritDoc
     */
    public function getHTML(): string {
        $img_src = wp_get_attachment_image_src(get_post_meta($this->post->ID, $this->id, true), 'full');
        ob_start();
        ?>

        <tr>
            <th scope="row">
                <label for="<?php echo $this->id; ?>"><?php echo $this->label; ?></label>
            </th>
            <td>
                <div class="app-post-type-image-uploader">
                    <input 
                        class="app-post-type-image-uploader__input" 
                        id="<?php echo $this->id; ?>" 
                        type="hidden" 
                        name="<?php echo $this->id; ?>" 
                        value="<?php echo $this->getValue(); ?>" 
                    />
                    <img 
                        src="<?php echo $img_src[0]; ?>" 
                        style="width: 300px;" 
                        alt="" 
                        class="app-post-type-image-uploader__preview<?php echo false === $img_src ? ' hide-app-post-type-image-uploader' : ''; ?>" <?php // phpcs:ignore?>
                        />
                    <div class="app-post-type-image-uploader__buttons">
                        <button class="app-post-type-image-uploader__button app-post-type-image-uploader__button--choose<?php echo false === $img_src ? '' : ' hide-app-post-type-image-uploader'; ?>"><?php _e('Choose image', 'app'); ?></button> <?php // phpcs:ignore?>
                        <button class="app-post-type-image-uploader__button app-post-type-image-uploader__button--remove<?php echo false === $img_src ? ' hide-app-post-type-image-uploader' : ''; ?>"><?php _e('Remove Image', 'app'); ?></button> <?php // phpcs:ignore?>
                    </div>
                </div>
            </td>
        </tr>

        <?php
        return ob_get_clean();
    }
}
