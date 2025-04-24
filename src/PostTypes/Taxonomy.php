<?php
/**
 * Abstract class for registering custom taxonomies
 *
 * @link       https://www.kotisivu.dev
 * @since      0.1.0
 *
 * @package    HeikkiVihersalo\CustomPostTypes
 */

namespace HeikkiVihersalo\CustomPostTypes;

use HeikkiVihersalo\CustomPostTypes\Interfaces\TaxonomyInterface;
use WP_Term;

/**
 * Abstract class for registering custom taxonomies
 *
 * @since      0.1.0
 * @package    HeikkiVihersalo\CustomPostTypes
 * @author     Heikki Vihersalo <heikki@vihersalo.fi>
 */
abstract class Taxonomy implements TaxonomyInterface {
    /**
     * Taxonomy type slug.
     *
     * @since 0.1.0
     * @access public
     * @var string
     */
    public $slug;

    /**
     * Taxonomy type name.
     *
     * @since 0.1.0
     * @access public
     * @var string
     */
    public $name;

    /**
     * Constructor
     *
     * @since    0.1.0
     * @access   public
     */
    public function __construct(string $slug, string $name) {
        $this->slug = $slug;
        $this->name = $name;
    }

    /**
     * @inheritDoc
     */
    public function register_custom_taxonomy(): void {
        /**
         * Get args
         */
        $args = [
            'public'             => $this->public(),
            'publicly_queryable' => $this->publicly_queryable(),
            'show_admin_column'  => $this->show_admin_column(),
            'hierarchical'       => $this->hierarchical(),
            'rewrite'            => $this->rewrite(),
            'show_in_quick_edit' => $this->show_in_quick_edit(),
            'meta_box_cb'        => $this->meta_box_cb(),
            'show_in_rest'       => true,
        ];

        if (count($this->labels()) !== 0) {
            $args['labels'] = $this->labels();
        }

        /**
         * Register post type
         */
        register_taxonomy(
            $this->slug,
            $this->object_types(),
            $args
        );

        if ($this->show_image_field()) {
            add_action($this->slug . '_add_form_fields', [$this, 'get_term_image_html'], 10, 1);
            add_action('created_' . $this->slug, [$this, 'add_term_image'], 10, 2);

            add_action($this->slug . '_edit_form_fields', [$this, 'get_term_image_html'], 10, 1);
            add_action('edited_' . $this->slug, [$this, 'update_term_image'], 10, 2);
        }
    }

    /**
     * @inheritDoc
     */
    public function register_custom_taxonomy_callbacks(): void {
        add_action('add_meta_boxes', [$this, 'add_custom_metabox'], 10, 2);
        add_action('save_post', [$this, 'save_custom_metabox_content']);
    }

    /**
     * @inheritDoc
     */
    public function labels() {
        return [];
    }

    /**
     * @inheritDoc
     */
    public function public(): bool {
        return true;
    }

    /**
     * @inheritDoc
     */
    public function publicly_queryable(): bool {
        return true;
    }

    /**
     * @inheritDoc
     */
    public function hierarchical(): bool {
        return true;
    }

    /**
     * @inheritDoc
     */
    public function rewrite(): bool|array {
        return [
            'slug'         => $this->slug,
            'with_front'   => true,
            'hierarchical' => false,
        ];
    }

    /**
     * @inheritDoc
     */
    public function show_admin_column(): bool {
        return true;
    }

    /**
     * @inheritDoc
     */
    public function show_in_quick_edit(): bool {
        return true;
    }

    /**
     * @inheritDoc
     */
    public function meta_box_cb(): string {
        return 'post_categories_meta_box';
    }

    /**
     * @inheritDoc
     */
    public function object_types(): string|array {
        return [];
    }

    /**
     * @inheritDoc
     */
    public function show_image_field(): bool {
        return false;
    }

    /**
     * @inheritDoc
     */
    public function get_term_image_html(WP_Term $term): void {
        $id       = $this->slug . '_term_image';
        $image_id = is_string($term) ? 0 : get_term_meta($term->term_id, $id, true);

        ?>
			<div class="form-field term-parent-wrap">
				<tr>
					<th scope="row">
						<label for="<?php echo $id; ?>">Term Image</label>
					</th>
					<td>
				<?php $img_src = wp_get_attachment_image_src($image_id, 'full'); ?>
						<div class="image-uploader">
							<input class="image-uploader__input" id="<?php echo $id; ?>" type="hidden" name="<?php echo $id; ?>" value="<?php echo $image_id; ?>" />
							<img src="<?php echo false === $img_src ? '' : $img_src[0]; ?>" style="width: 300px;" alt="" class="image-uploader__preview<?php echo false === $img_src ? ' hide-image-uploader' : ''; ?>" />
							<div class="image-uploader__buttons">
								<button type="button" class="image-uploader__button image-uploader__button--choose<?php echo false === $img_src ? '' : ' hide-image-uploader'; ?>"><?php _e('Choose image', 'heikkivihersalo-custom-post-types'); ?></button>
								<button type="button" class="image-uploader__button image-uploader__button--remove<?php echo false === $img_src ? ' hide-image-uploader' : ''; ?>"><?php _e('Remove Image', 'heikkivihersalo-custom-post-types'); ?></button>
							</div>
						</div>
					</td>
				</tr>
			</div>
			<?php
    }

    /**
     * @inheritDoc
     */
    public function add_term_image(int $term_id, int $term_taxonomy_id): void {
        $id = $this->slug . '_term_image';

        if (isset($_POST[ $id ]) && '' !== $_POST[ $id ]) { // phpcs:ignore
            $response = add_term_meta($term_id, $id, sanitize_text_field($_POST[ $id ]), true); // phpcs:ignore
        }
    }

    /**
     * @inheritDoc
     */
    public function update_term_image(int $term_id, int $term_taxonomy_id): void {
        $id = $this->slug . '_term_image';

        if (isset($_POST[ $id ]) && '' !== $_POST[ $id ]) { // phpcs:ignore
            $response = update_term_meta($term_id, $id, sanitize_text_field($_POST[ $id ])); // phpcs:ignore
        }
    }

    /**
     * @inheritDoc
     */
    abstract protected function register(): void;
}
