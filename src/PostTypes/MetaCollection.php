<?php

declare(strict_types=1);

namespace Vihersalo\Core\PostTypes;

use InvalidArgumentException;

class MetaCollection {
    /**
     * The registered fields in the collection.
     * @var array
     */
    private $registeredFields = [];

    /**
     * Constructor
     * @return void
     */
    public function __construct(FieldCollection $registeredFields) {
        $this->registeredFields = $registeredFields;
    }

    /**
     * Get all the fields and their values for the current post type.
     *
     * @param int|null $id The post ID. If null, the current post ID will be used.
     * @return array|null The fields and their values.
     */
    public function all(?int $id = null): array|null {
        // Get post meta for the current post type
        $postId = $id ?? \get_the_ID();
        $fields = $this->registeredFields->registered();
        $meta   = [];

        foreach ($fields as $field) {
            $metaKey = $field['id']      ?? null;
            $type    = $field['type']    ?? null;
            $options = $field['options'] ?? null;

            $meta[$metaKey] = $this->getPostMeta($postId, $metaKey, $type, $options);
        }

        return $meta;
    }

    /**
     * Get the value of a specific field.
     *
     * @param string $key The field key.
     * @param int|null $id The post ID. If null, the current post ID will be used.
     * @return array|null The field value.
     * @throws InvalidArgumentException If the field key is not found in the collection.
     */
    public function value(string $key, ?int $id = null): string|array|null {
        $postId = $id ?? \get_the_ID();

        foreach ($this->registeredFields as $field) {
            if ($field['id'] === $key) {
                return $this->getPostMeta($postId, $key, $field['type'], $field['options']);
            }
        }

        throw new InvalidArgumentException("Field with key {$key} not found in the collection.");
    }

    /**
     * Get the post meta for a specific field.
     *
     * @param int $id The post ID.
     * @param string $key The field key.
     * @param string $type The field type.
     * @param array $options The field options.
     * @return mixed The formatted post meta value.
     */
    protected function getPostMeta($id, $key, $type, $options) {
        switch ($type) {
            case 'text':
            case 'textarea':
            case 'email':
            case 'url':
            case 'select':
            case 'radio':
                return Utils::formatPostMetaText($id, $key);

            case 'number':
                return Utils::formatPostMetaNumber($id, $key);

            case 'checkbox':
                return Utils::formatPostMetaCheckbox($id, $key);

            case 'checkbox-group':
                return Utils::formatPostMetaCheckboxGroup($id, $key, $options);

            case 'image':
                return Utils::formatPostMetaImage($id, $key);

            default:
                return Utils::formatPostMetaText($id, $key);
        }
    }
}
