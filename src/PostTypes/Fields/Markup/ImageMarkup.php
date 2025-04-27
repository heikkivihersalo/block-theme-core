<?php

namespace Vihersalo\Core\PostTypes\Fields\Markup;

class ImageMarkup {
    /**
     * ID of the field
     */
    protected $id;

    /**
     * Label of the field
     */
    protected $label;

    /**
     * Value of the field
     */
    protected $value;

    /**
     * Image src
     */
    protected $src;

    /**
     * Constructor
     *
     * @param string $id    ID of the field
     * @param string $label Label of the field
     * @param string $value Value of the field
     * @param array|false $src   Image src
     */
    public function __construct($id, $label, $value, $src) {
        $this->id    = $id;
        $this->label = $label;
        $this->value = $value;
        $this->src   = $src;
    }

    /**
     * Get the id of the field
     * @return string
     */
    public function getId() {
        return $this->id;
    }

    /**
     * Get the value of the field
     * @return string
     */
    public function getValue() {
        return $this->value;
    }

    /**
     * Get the label of the field
     * @return string
     */
    public function getLabel() {
        return $this->label;
    }

    /**
     * Get the image src
     * @return array|false
     * @see https://developer.wordpress.org/reference/functions/wp_get_attachment_image_src/
     */
    public function getSrc() {
        return $this->src;
    }

    /**
     * Get the HTML markup for the field
     * @return string
     */
    public function markup(): string {
        ob_start();
        ?>

        <tr>
            <th scope="row">
                <label for="<?php echo $this->getId(); ?>"><?php echo $this->getLabel(); ?></label>
            </th>
            <td>
                <div class="app-post-type-image-uploader">
                    <input 
                        class="app-post-type-image-uploader__input" 
                        id="<?php echo $this->getId(); ?>" 
                        type="hidden" 
                        name="<?php echo $this->getId(); ?>" 
                        value="<?php echo $this->getValue(); ?>" 
                    />
                    <img 
                        src="<?php echo ($this->getSrc())[0]; ?>" 
                        style="width: 300px;" 
                        alt="" 
                        class="app-post-type-image-uploader__preview<?php echo false === $this->getSrc() ? ' hide-app-post-type-image-uploader' : ''; ?>" <?php // phpcs:ignore?>
                        />
                    <div class="app-post-type-image-uploader__buttons">
                        <button class="app-post-type-image-uploader__button app-post-type-image-uploader__button--choose<?php echo false === $this->getSrc() ? '' : ' hide-app-post-type-image-uploader'; ?>"><?php _e('Choose image', 'app'); ?></button> <?php // phpcs:ignore?>
                        <button class="app-post-type-image-uploader__button app-post-type-image-uploader__button--remove<?php echo false === $this->getSrc() ? ' hide-app-post-type-image-uploader' : ''; ?>"><?php _e('Remove Image', 'app'); ?></button> <?php // phpcs:ignore?>
                    </div>
                </div>
            </td>
        </tr>

        <?php
        return ob_get_clean();
    }
}
