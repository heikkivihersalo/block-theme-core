<?php

declare(strict_types=1);

namespace Vihersalo\Core\Support\Models;

// use HeikkiVihersalo\CustomPostTypes\Traits\CustomPermalink;

use Vihersalo\Core\Contracts\PostTypes\PostType as PostTypeContract;
use Vihersalo\Core\PostTypes\FieldCollection;
use Vihersalo\Core\PostTypes\FieldRegistrar;
use Vihersalo\Core\PostTypes\Utils as PostTypeUtils;

/**
 * Abstract class for registering custom post types
 *
 * @since      0.1.0
 * @package    HeikkiVihersalo\CustomPostTypes
 * @author     Heikki Vihersalo <heikki@vihersalo.fi>
 */
abstract class PostType implements PostTypeContract {
    /**
     * Prefix for the database entry
     * @var string
     */
    protected $prefix;

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
     * Constructor
     */
    public function __construct() {
        if (empty($this->slug)) {
            $this->slug = $this->resolvePostTypeSlug();
        }

        if (empty($this->name)) {
            $this->name = $this->resolvePostTypeName();
        }

        if (empty($this->prefix)) {
            $this->prefix = $this->resolvePrefix();
        }

        if (empty($this->fields)) {
            $this->fields = new FieldCollection();
        }
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
        if (empty(get_option($this->prefix . $this->slug))) {
            return [
                'slug' => $this->slug
            ];
        }

        return [
            'slug' => get_option($this->prefix . $this->slug),
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
     * @inheritDoc
     */
    protected function resolvePrefix(): string {
        return 'app-cpt-';
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
            $id   = $field['id']   ?? null;
            $type = $field['type'] ?? null;

            switch ($type) {
                case 'text':
                case 'textarea':
                case 'email':
                case 'url':
                    $meta[$id] = \get_post_meta($postId, $id, true);
                    break;

                case 'number':
                    $meta[$id] = (int) \get_post_meta($postId, $id, true);
                    break;

                case 'checkbox':
                    $meta[$id] = \get_post_meta($postId, $id, true) ? true : false;
                    break;

                    /**
                     * Checkbox values are stored to the database with each enabled
                     * value to its own row (naming convention: {id}_{key}).
                     * We need to get all the values and return them as an array.
                     */
                case 'checkbox-group':
                    $arr = [];

                    foreach ($field['options'] as $key => $value) {
                        $dbValue = \get_post_meta($postId, $id . '_' . $key, true);
                        if ($dbValue) {
                            $arr[] = $key;
                        }
                    }

                    $meta[$id] = $arr;

                    break;
                case 'select':
                    $meta[$id] = \get_post_meta($postId, $id, true);
                    break;

                case 'radio':
                    $meta[$id] = \get_post_meta($postId, $id, true);
                    break;

                case 'image':
                    $meta[$id] = PostTypeUtils::formatPostMetaImage($postId, $id);
                    break;

                default:
                    $meta[$id] = \get_post_meta($postId, $id, true);
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
}
