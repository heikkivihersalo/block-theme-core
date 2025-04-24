<?php

declare(strict_types=1);

namespace Vihersalo\Core\Contracts\PostTypes;

use Vihersalo\Core\PostTypes\FieldCollection;

/**
 * Post Type Interface
 *
 * @package HeikkiVihersalo\CustomPostTypes\Interfaces
 * @since 0.1.0
 */
interface PostType {
    /**
     * Register post type
     *
     * @return void
     */
    public function registerCustomPostType(): void;

    /**
     * Resolve post type slug from the class name
     *
     * @return string
     */
    public function resolvePostTypeSlug(): string;

    /**
     * Resolve post type name from the class name
     *
     * @return string
     */
    public function resolvePostTypeName(): string;

    /**
     * Custom Post Type Labels for post type
     *
     * @return array
     */
    public function labels(): array;

    /**
     * Public or not
     *
     * @return bool
     */
    public function public(): bool;

    /**
     * Has archive
     *
     * @return bool
     */
    public function hasArchive(): bool;


    /**
     * Add support for post type
     *
     * @return array
     */
    public function supports(): array;

    /**
     * Taxonomies for post type
     *
     * @return array
     */
    public function taxonomies(): array;

    /**
     * Rewrite rules for post type
     *
     * @return array
     */
    public function rewrite(): array;

    /**
     * Icon for post type
     *
     * @return string
     */
    public function icon(): string;

    /**
     * Show in Rest API (Required for Gutenberg)
     *
     * @return bool
     */
    public function showInRest(): bool;

    /**
     * Set custom post type fields
     *
     * @param FieldCollection $fields Post type fields
     * @return void
     */
    public function fields(FieldCollection $fields): void;
}
