<?php

namespace Vihersalo\Core\PostTypes\Fields\Markup;

class ImageMarkup {
    /**
     * ID of the field
     * @var string
     */
    protected $id;

    /**
     * Label of the field
     * @var string
     */
    protected $label;

    /**
     * Value of the field
     * @var string
     */
    protected $value;

    /**
     * Image
     * @var array|false
     * @see https://developer.wordpress.org/reference/functions/wp_get_attachment_image_src/
     */
    protected $image;

    /**
     * Constructor
     *
     * @param string $id    ID of the field
     * @param string $label Label of the field
     * @param string $value Value of the field
     * @param array|false $src   Image src
     */
    public function __construct(string $id, string $label, string $value, array|false $image) {
        $this->id    = $id;
        $this->label = $label;
        $this->value = $value;
        $this->image = $image;
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
    public function getImage() {
        return $this->image;
    }

    /**
     * Get the HTML markup for the field
     * @return string
     */
    public function markup(): string {
        $src      = ($this->getImage())[0] ?? false;
        $hasImage = $src !== false;
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
                        src="<?php echo $src; ?>" 
                        style="width: 300px;" 
                        alt="" 
                        class="app-post-type-image-uploader__preview"
                        data-hidden="<?php echo !$hasImage; ?>"
                        />
                    <div class="app-post-type-image-uploader__buttons">
                        <button 
                            class="app-post-type-image-uploader__button app-post-type-image-uploader__button--choose"
                            data-hidden="<?php echo $hasImage; ?>"
                        >
                            <?php _e('Choose image', 'app'); ?>
                        </button>
                        <button 
                            class="app-post-type-image-uploader__button app-post-type-image-uploader__button--remove"
                            data-hidden="<?php echo !$hasImage; ?>"
                        >
                            <?php _e('Remove Image', 'app'); ?>
                        </button>
                    </div>
                </div>
            </td>
        </tr>

        <?php
        return ob_get_clean();
    }
}
