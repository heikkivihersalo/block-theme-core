<?php

declare(strict_types=1);

namespace Vihersalo\Core\Support\Models;

// use HeikkiVihersalo\CustomPostTypes\Traits\CustomPermalink;

use Vihersalo\Core\Contracts\PostTypes\PostType as PostTypeContract;
use Vihersalo\Core\PostTypes\FieldCollection;
use Vihersalo\Core\PostTypes\FieldRegistrar;
use Vihersalo\Core\PostTypes\Utils as PostTypeUtils;
use WP_Block_Bindings_Registry;

/**
 * Abstract class for registering custom post types
 *
 * @since      0.1.0
 * @package    HeikkiVihersalo\CustomPostTypes
 * @author     Heikki Vihersalo <heikki@vihersalo.fi>
 */
abstract class PostType implements PostTypeContract {
    /**
     * Post type slug.
     * @var string
     */
    protected $slug;

    /**
     * Post type name.
     * @var string
     */
    protected $name;

    /**
     * Custom fields.
     * @var FieldCollection
     */
    protected $fields;

    /**
     * Hidden fields.
     * @var array
     */
    protected $hidden = [];

    /**
     * Constructor
     */
    public function __construct() {
        if (empty($this->slug)) {
            $this->slug = $this->resolvePostTypeSlug();
        }

        if (empty($this->name)) {
            $this->name = $this->resolvePostTypeName();
        }

        if (empty($this->fields)) {
            $this->fields = new FieldCollection();
        }
    }

    /**
     * Get the post type name
     * @return string
     */
    protected function getName(): string {
        return $this->name;
    }

    /**
     * Get the post type slug
     * @return string
     */
    protected function getSlug(): string {
        return $this->slug;
    }

    /**
     * @inheritDoc
     */
    public function labels(): array {
        return [
            'name'               => $this->name,
            'singular_name'      => $this->name,
            'menu_name'          => $this->name,
            'name_admin_bar'     => $this->name,
            'add_new'            => 'Add New ' . $this->name,
            'add_new_item'       => 'Add New ' . $this->name,
            'new_item'           => 'New ' . $this->name,
            'edit_item'          => 'Edit ' . $this->name,
            'view_item'          => 'View ' . $this->name,
            'all_items'          => 'All ' . $this->name . 's',
            'search_items'       => 'Search ' . $this->name . 's',
            'parent_item_colon'  => 'Parent ' . $this->name . ':',
            'not_found'          => 'No ' . $this->name . ' found.',
            'not_found_in_trash' => 'No ' . $this->name . ' found in Trash.',
        ];
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
    public function hasArchive(): bool {
        return true;
    }

    /**
     * @inheritDoc
     */
    public function supports(): array {
        return [
            'title',
            'editor',
            'thumbnail',
        ];
    }

    /**
     * @inheritDoc
     */
    public function taxonomies(): array {
        return [];
    }

    /**
     * @inheritDoc
     */
    public function rewrite(): array {
        if (empty(get_option('cpt-permalink-' . $this->slug))) {
            return [
                'slug' => $this->slug
            ];
        }

        return [
            'slug' => get_option('cpt-permalink-' . $this->slug),
        ];
    }

    /**
     * @inheritDoc
     */
    public function icon(): string {
        return 'dashicons-pressthis';
    }

    /**
     * @inheritDoc
     */
    public function showInRest(): bool {
        return true;
    }

    /**
     * @inheritDoc
     */
    public function fields(): void {
    }

    /**
     * @inheritDoc
     */
    public function hidden(): array {
        return $this->hidden;
    }

    /**
     * @inheritDoc
     */
    protected function resolvePostTypeSlug(): string {
        return \strtolower(\str_replace('\\', '-', \get_class($this)));
    }

    /**
     * @inheritDoc
     */
    protected function resolvePostTypeName(): string {
        return \ucwords(\str_replace('-', ' ', $this->slug));
    }

    /**
     * Register post type
     *
     * @return void
     */
    public function registerPostType() {
        \register_post_type(
            $this->slug,
            [
                'labels'       => $this->labels(),
                'public'       => $this->public(),
                'has_archive'  => $this->hasArchive(),
                'taxonomies'   => $this->taxonomies(),
                'rewrite'      => $this->rewrite(),
                'supports'     => $this->supports(),
                'show_in_rest' => $this->showInRest(),
                'menu_icon'    => $this->icon(),
            ]
        );
    }

    /**
     * Register custom fields
     *
     * @return void
     */
    public function registerCustomFields() {
        // Initialize the fields
        $this->fields();

        if ($this->fields->isEmpty()) {
            return;
        }

        $customFields = new FieldRegistrar(
            $this->fields,
            'Custom Fields',
            [$this->slug],
        );

        $customFields->register();
    }

    /**
     * Format the post meta for REST API based on the defined fields
     *
     * @param int   $id    The post ID
     * @param array $fields The fields to format
     * @return array The formatted post meta
     */
    public function getPostMeta(int $postId, array $fields): array {
        $meta = [];

        foreach ($fields as $field) {
            $metaKey = $field['id']      ?? null;
            $type    = $field['type']    ?? null;
            $options = $field['options'] ?? null;

            // Check if the field is hidden
            // We want to hide the field from the REST API
            if (\in_array($metaKey, $this->hidden(), true)) {
                continue;
            }

            // Continue to check the type so we can format the meta
            switch ($type) {
                case 'text':
                case 'textarea':
                case 'email':
                case 'url':
                case 'select':
                case 'radio':
                    $meta[$metaKey] = PostTypeUtils::formatPostMetaText($postId, $metaKey);
                    break;

                case 'number':
                    $meta[$metaKey] = PostTypeUtils::formatPostMetaNumber($postId, $metaKey);
                    break;

                case 'checkbox':
                    $meta[$metaKey] = PostTypeUtils::formatPostMetaCheckbox($postId, $metaKey);
                    break;

                case 'checkbox-group':
                    $meta[$metaKey] = PostTypeUtils::formatPostMetaCheckboxGroup($postId, $metaKey, $options);
                    break;

                case 'image':
                    $meta[$metaKey] = PostTypeUtils::formatPostMetaImage($postId, $metaKey);
                    break;

                default:
                    $meta[$metaKey] = PostTypeUtils::formatPostMetaText($postId, $metaKey);
                    break;
            }
        }

        return $meta;
    }

    /**
     * Register post type custom fields to REST API
     *
     * @return void
     */
    public function registerRestFields(): void {
        $this->fields(); // Initialize the fields
        \register_rest_field(
            $this->slug,
            'metadata',
            [
                'get_callback' => function ($data) {
                    $meta['fields'] = $this->getPostMeta($data['id'], $this->fields->all());
                    return $meta;
                },
            ]
        );
    }

    /**
     * Register block bindings for the custom fields
     *
     * @return void
     */
    public function registerBlockBindings(): void {
        $this->fields(); // Initialize the fields
        $fields = $this->fields->all();

        foreach ($fields as $field) {
            $metaKey   = $field['id']      ?? null;
            $type      = $field['type']    ?? null;
            $label     = $field['label']   ?? null;
            $options   = $field['options'] ?? null;
            $namespace = 'app/' . str_replace('_', '-', $metaKey);

            if (WP_Block_Bindings_Registry::get_instance()->is_registered($namespace)) {
                continue;
            }

            if (empty($metaKey) || empty($type)) {
                continue;
            }

            if (empty($label)) {
                $label = \ucwords(\str_replace(['-', '_'], ' ', $metaKey));
            }

            switch ($type) {
                case 'text':
                case 'textarea':
                case 'email':
                case 'url':
                case 'select':
                case 'radio':
                    \register_block_bindings_source(
                        $namespace,
                        [
                            'label'              => $label,
                            'get_value_callback' => function (array $source_args, $block_instance) use ($metaKey) {
                                if (empty($block_instance->context['postId'])) {
                                    return null;
                                }

                                return PostTypeUtils::formatPostMetaText($block_instance->context['postId'], $metaKey);
                            },
                            'uses_context' => ['postId']
                        ]
                    );
                    break;

                default:
                    break;
            }
        }
    }
}
