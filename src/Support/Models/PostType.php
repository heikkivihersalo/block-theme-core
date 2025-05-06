<?php

declare(strict_types=1);

namespace Vihersalo\Core\Support\Models;

// use HeikkiVihersalo\CustomPostTypes\Traits\CustomPermalink;

use Vihersalo\Core\Contracts\PostTypes\PostType as PostTypeContract;
use Vihersalo\Core\PostTypes\FieldCollection;
use Vihersalo\Core\PostTypes\FieldRegistrar;

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

        // Initialize the fields
        if (empty($this->fields)) {
            $this->fields = new FieldCollection();
        }

        $this->fields();
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
     * Register post type
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
     * @return void
     */
    public function registerCustomFields() {
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
     * Get the post type fields
     * @return FieldCollection
     */
    protected function getFields(): FieldCollection {
        return $this->fields;
    }

    /**
     * Resolve the post type slug
     * @return string
     */
    protected function resolvePostTypeSlug(): string {
        return \strtolower(\str_replace('\\', '-', \get_class($this)));
    }

    /**
     * Resolve the post type name
     * @return string
     */
    protected function resolvePostTypeName(): string {
        return \ucwords(\str_replace('-', ' ', $this->slug));
    }
}
