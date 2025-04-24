<?php

declare(strict_types=1);

namespace Vihersalo\Core\PostTypes;

use Vihersalo\Core\Contracts\PostTypes\CustomField as CustomFieldContract;
use WP_Post;

/**
 * Custom field class for custom post types
 *
 *
 * @package HeikkiVihersalo\CustomPostTypes\CustomFields
 */
abstract class CustomField implements CustomFieldContract {
    /**
     * Field id
     *
     * @var string
     */
    protected string $id;

    /**
     * Field label
     *
     * @var string
     */
    protected string $label;

    /**
     * Post
     *
     * @var WP_Post
     */
    protected $post;

    /**
     * Field options
     *
     * @var array
     */
    protected $options;

    /**
     * @inheritDoc
     */
    public function __construct(string $id, string $label = '', ?WP_Post $post = null, array $options = []) {
        $this->id      = $id;
        $this->label   = $label;
        $this->post    = $post;
        $this->options = $options;
    }

    /**
     * @inheritDoc
     */
    public function getId(): string {
        return $this->id;
    }

    /**
     * @inheritDoc
     */
    public function getLabel(): string {
        if (empty($this->label)) {
            return $this->id;
        }

        return $this->label;
    }

    /**
     * @inheritDoc
     */
    public function getPost(): WP_Post {
        return $this->post;
    }

    /**
     * @inheritDoc
     */
    public function getOptions(): array {
        return $this->options;
    }

    /**
     * @inheritDoc
     */
    public function getValue(): string {
        return esc_attr(get_post_meta($this->post->ID, $this->id, true));
    }

    /**
     * @inheritDoc
     */
    public function getTaxonomyValue(): string {
        $currentValue = get_the_terms(get_the_ID(), $this->taxonomy);

        if (! $currentValue) {
            return '';
        }

        return $currentValue[0]->term_id;
    }

    /**
     * @inheritDoc
     */
    abstract public function getHTML(): string;

    /**
     * @inheritDoc
     */
    public function sanitize(string $value): string {
        return sanitize_text_field($value);
    }

    /**
     * @inheritDoc
     */
    public function sanitizeTaxonomy(string $value): string {
        return (int) sanitize_text_field($value);
    }

    /**
     * @inheritDoc
     */
    public function save(int $post_id, array $options = []): void {
        // Nonce verification is done in the parent class so we can safely ignore it here.
        if (array_key_exists($this->id, $_POST)) { // phpcs:ignore WordPress.Security.NonceVerification.Missing
            $val = $this->sanitize($_POST[$this->id]); // phpcs:ignore
            update_post_meta($post_id, $this->id, $val);
        }
    }

    /**
     * @inheritDoc
     */
    public function saveGroup(int $post_id, array $options): void {
        foreach ($options as $option) {
            // Nonce verification is done in the parent class so we can safely ignore it here.
            if (isset($_POST[ $this->id . '_' . $option['value'] ])) {
                update_post_meta($post_id, $this->id . '_' . $option['value'], '1');
            } else {
                delete_post_meta($post_id, $this->id . '_' . $option['value']);
            }
        }
    }

    /**
     * Check if WP_Term is checked
     * @param int        $term_id WP_Term ID
     * @param array|bool $taxonomies Array of WP_Term objects to check
     * @return string
     */
    public function isTermChecked(int $term_id, array|bool $taxonomies): string {
        foreach ($taxonomies as $current_taxonomy) {
            if ($current_taxonomy->term_id === $term_id) {
                return 'checked';
            }
        }

        return '';
    }

    /**
     * @inheritDoc
     */
    public function registerRestField(): void {
        register_rest_field(
            $this->post_types,
            $this->id,
            [
                'get_callback' => function ($post) {
                    return get_post_meta($post['id'], $this->id, true);
                },
                'schema' => [
                    'description' => $this->label,
                    'type'        => 'string',
                ],
            ]
        );
    }
}
