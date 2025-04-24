<?php

declare(strict_types=1);

namespace Vihersalo\Core\Contracts\PostTypes;

use WP_Term;

/**
 * Post Type Interface
 *
 * @package HeikkiVihersalo\CustomPostTypes\Interfaces
 * @since 0.1.0
 */
interface Taxonomy {
    /**
     * Register custom taxonomy
     *
     * @since 0.1.0
     * @access public
     * @return void
     */
    public function registerCustomTaxonomy(): void;

    /**
     * Register custom taxonomy callbacks
     *
     * @since 0.2.0
     * @access public
     * @return void
     */
    public function registerCustomTaxonomyCallbacks(): void;

    /**
     * Custom Post Type Labels for post type
     *
     * @since 0.1.0
     * @access public
     * @return array
     */
    public function labels();

    /**
     * Whether a taxonomy is intended for use publicly either via the admin interface or by front-end users.
     * The default settings of $publicly_queryable, $show_ui, and $show_in_nav_menus are inherited from $public
     *
     * @since 0.1.0
     * @access public
     * @return bool
     */
    public function public(): bool;

    /**
     * Whether the taxonomy is publicly queryable.
     *
     * @since 0.2.0
     * @access public
     * @return bool
     */
    public function publiclyQueryable(): bool;

    /**
     * Hierarchical
     *
     * @since 0.1.0
     * @access public
     * @return bool
     */
    public function hierarchical(): bool;

    /**
     * Rewrite
     *
     * @since 0.1.0
     * @access public
     * @return string
     */
    public function rewrite(): bool|array;

    /**
     * Show admin column
     *
     * @since 0.1.0
     * @access public
     * @return bool
     */
    public function showAdminColumn(): bool;

    /**
     * Show in quick edit
     *
     * @since 0.2.0
     * @access public
     * @return bool
     */
    public function showInQuickEdit(): bool;

    /**
     * Meta box callback
     *
     * @since 0.2.0
     * @access public
     * @return string
     */
    public function metaBoxCb(): string;

    /**
     * Object types
     *
     * @since 0.2.0
     * @access public
     * @return string|array
     */
    public function objectTypes(): string|array;

    /**
     * Show image field
     *
     * @since 0.2.0
     * @access public
     * @return bool
     */
    public function showImageField(): bool;

    /**
     * Get term image html
     *
     * @since 0.2.0
     * @access public
     * @param WP_Term $term Term object.
     * @return void
     */
    public function getTermImageHTML(WP_Term $term): void;

    /**
     * Add term image
     *
     * @since 0.2.0
     * @access public
     * @param int $term_id Term ID.
     * @param int $term_taxonomy_id Term taxonomy ID.
     * @return void
     */
    public function addTermImage(int $term_id, int $term_taxonomy_id): void;


    /**
     * Update term image
     *
     * @since 0.2.0
     * @access public
     * @param int $term_id Term ID.
     * @param int $term_taxonomy_id Term taxonomy ID.
     * @return void
     */
    public function updateTermImage(int $term_id, int $term_taxonomy_id): void;

    /**
     * Get arguments
     *
     * @since 0.1.0
     * @access public
     * @return array
     */
    public function getArguments(): array;
}
