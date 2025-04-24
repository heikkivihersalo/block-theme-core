<?php

declare(strict_types=1);

namespace Vihersalo\Core\Contracts\PostTypes;

use WP_Post;

/**
 * Custom field interface
 *
 */
interface CustomField {
    /**
     * Constructor
     *
     * @param string   $id    ID for field
     * @param string   $label Label for field
     * @param WP_Post $post   WP_Post object
     * @param array    $options Array of options for field
     * @return void
     */
    public function __construct(string $id, string $label = '', ?WP_Post $post = null, array $options = []);

    /**
     * Get id
     *
     * @return string
     */
    public function getId(): string;

    /**
     * Get label
     *
     * @return string
     */
    public function getLabel(): string;

    /**
     * Get post
     *
     * @return WP_Post
     */
    public function getPost(): WP_Post;

    /**
     * Get options
     *
     * @return array
     */
    public function getOptions(): array;

    /**
     * Get current value of field
     *
     * @return string
     */
    public function getValue(): string;

    /**
     * Get field html
     *
     * @param array  $field Data for field
     * @param string $value Field value
     * @return void
     */
    public function getHTML();

    /**
     * Sanitize field
     *
     * @param string $value Field value
     * @return string
     */
    public function sanitize(string $value): string;

    /**
     * Save field
     *
     * @param int $post_id Post ID
     * @return int
     */
    public function save(int $post_id, array $options = []): void;

    /**
     * Register rest field
     *
     * @return void
     */
    public function registerRestField(): void;
}
