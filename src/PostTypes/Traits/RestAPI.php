<?php

declare(strict_types=1);

namespace Vihersalo\Core\PostTypes\Traits;

use Vihersalo\Core\PostTypes\Utils;

trait RestAPI {
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
            if (\in_array($metaKey, parent::hidden(), true)) {
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
                    $meta[$metaKey] = Utils::formatPostMetaText($postId, $metaKey);
                    break;

                case 'number':
                    $meta[$metaKey] = Utils::formatPostMetaNumber($postId, $metaKey);
                    break;

                case 'checkbox':
                    $meta[$metaKey] = Utils::formatPostMetaCheckbox($postId, $metaKey);
                    break;

                case 'checkbox-group':
                    $meta[$metaKey] = Utils::formatPostMetaCheckboxGroup($postId, $metaKey, $options);
                    break;

                case 'image':
                    $meta[$metaKey] = Utils::formatPostMetaImage($postId, $metaKey);
                    break;

                default:
                    $meta[$metaKey] = Utils::formatPostMetaText($postId, $metaKey);
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
        parent::fields(); // Initialize the fields
        \register_rest_field(
            parent::getSlug(),
            'metadata',
            [
                'get_callback' => function ($data) {
                    $meta['fields'] = $this->getPostMeta($data['id'], parent::getRegisteredFields());
                    return $meta;
                },
            ]
        );
    }
}
