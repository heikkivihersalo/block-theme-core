<?php

declare(strict_types=1);

namespace Vihersalo\Core\Contracts\PostTypes;

/**
 * Post Type Interface
 *
 * @package HeikkiVihersalo\CustomPostTypes\Interfaces
 * @since 0.1.0
 */
interface PostType {
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
     * @return void
     */
    public function fields(): void;

    /**
     * Hidden fields
     *
     * @return array
     */
    public function hidden(): array;
}
