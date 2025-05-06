<?php

declare(strict_types=1);

namespace Vihersalo\Core\PostTypes;

use InvalidArgumentException;

class FieldCollection {
    /**
     * The registered fields in the collection.
     * @var array
     */
    private $registeredFields = [];

    /**
     * Constructor
     * @return void
     */
    public function __construct() {
    }

    /**
     * Get the registered fields.
     *
     * @return array
     */
    public function registered(): array {
        return $this->registeredFields;
    }

    /**
     * Add a text field to the collection.
     *
     * @param string $id The field ID.
     * @param string $label The field label.
     * @return void
     */
    public function addText(string $id, string $label): void {
        $this->registeredFields[] = [
            'id'    => $id,
            'label' => $label,
            'type'  => 'text',
        ];
    }

    /**
     * Add a textarea field to the collection.
     *
     * @param string $id The field ID.
     * @param string $label The field label.
     * @return void
     */
    public function addTextArea(string $id, string $label): void {
        $this->registeredFields[] = [
            'id'    => $id,
            'label' => $label,
            'type'  => 'textarea',
        ];
    }

    /**
     * Add a URL field to the collection.
     *
     * @param string $id The field ID.
     * @param string $label The field label.
     * @return void
     */
    public function addUrl(string $id, string $label): void {
        $this->registeredFields[] = [
            'id'    => $id,
            'label' => $label,
            'type'  => 'url',
        ];
    }

    /**
     * Add a number field to the collection.
     *
     * @param string $id The field ID.
     * @param string $label The field label.
     * @return void
     */
    public function addNumber(string $id, string $label): void {
        $this->registeredFields[] = [
            'id'    => $id,
            'label' => $label,
            'type'  => 'number',
        ];
    }

    /**
     * Add a checkbox field to the collection.
     *
     * @param string $id The field ID.
     * @param string $label The field label.
     * @return void
     */
    public function addCheckbox(string $id, string $label): void {
        $this->registeredFields[] = [
            'id'    => $id,
            'label' => $label,
            'type'  => 'checkbox',
        ];
    }

    /**
     * Add a checkbox group field to the collection.
     *
     * @param string $id The field ID.
     * @param string $label The field label.
     * @param array $options The options for the checkbox group.
     * @return void
     */
    public function addCheckboxGroup(string $id, string $label, array $options): void {
        $this->registeredFields[] = [
            'id'      => $id,
            'label'   => $label,
            'type'    => 'checkbox-group',
            'options' => $options,
        ];
    }

    /**
     * Add a date field to the collection.
     *
     * @param string $id The field ID.
     * @param string $label The field label.
     * @return void
     */
    public function addDate(string $id, string $label): void {
        $this->registeredFields[] = [
            'id'    => $id,
            'label' => $label,
            'type'  => 'date',
        ];
    }

    /**
     * Add an image field to the collection.
     *
     * @param string $id The field ID.
     * @param string $label The field label.
     * @return void
     */
    public function addImage(string $id, string $label): void {
        $this->registeredFields[] = [
            'id'    => $id,
            'label' => $label,
            'type'  => 'image',
        ];
    }

    /**
     * Add a select field to the collection.
     *
     * @param string $id The field ID.
     * @param string $label The field label.
     * @param FieldOptions $options The options for the select field.
     * @return void
     */
    public function addSelect(string $id, string $label, array $options): void {
        $this->registeredFields[] = [
            'id'      => $id,
            'label'   => $label,
            'type'    => 'select',
            'options' => $options,
        ];
    }

    /**
     * Add a rich text field to the collection.
     *
     * @param string $id The field ID.
     * @param string $label The field label.
     * @return void
     */
    public function addRichText(string $id, string $label): void {
        $this->registeredFields[] = [
            'id'    => $id,
            'label' => $label,
            'type'  => 'rich-text',
        ];
    }

    /**
     * Add a radio group field to the collection.
     *
     * @param string $id The field ID.
     * @param string $label The field label.
     * @param FieldOptions $options The options for the radio group.
     * @return void
     */
    public function addRadioGroup(string $id, string $label, array $options): void {
        $this->registeredFields[] = [
            'id'      => $id,
            'label'   => $label,
            'type'    => 'radio-group',
            'options' => $options,
        ];
    }

    /**
     * Add a taxonomy checkbox group field to the collection.
     *
     * @param string $id The field ID.
     * @param string $label The field label.
     * @param string $taxonomy The taxonomy slug.
     * @return void
     */
    public function addTaxonomyCheckboxGroup(string $id, string $label, string $taxonomy): void {
        $this->registeredFields[] = [
            'id'       => $id,
            'label'    => $label,
            'type'     => 'taxonomy-checkbox-group',
            'taxonomy' => $taxonomy,
        ];
    }

    /**
     * Add a taxonomy radio field to the collection.
     *
     * @param string $id The field ID.
     * @param string $label The field label.
     * @param string $taxonomy The taxonomy slug.
     * @return void
     */
    public function addTaxonomyRadio(string $id, string $label, string $taxonomy): void {
        $this->registeredFields[] = [
            'id'       => $id,
            'label'    => $label,
            'type'     => 'taxonomy-radio',
            'taxonomy' => $taxonomy,
        ];
    }
    /**
     * Add a taxonomy select field to the collection.
     *
     * @param string $id The field ID.
     * @param string $label The field label.
     * @param string $taxonomy The taxonomy slug.
     * @return void
     */
    public function addTaxonomySelect(string $id, string $label, string $taxonomy): void {
        $this->registeredFields[] = [
            'id'       => $id,
            'label'    => $label,
            'type'     => 'taxonomy-select',
            'taxonomy' => $taxonomy,
        ];
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
        $fields = $this->registered();
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

    /**
     * Get the number of items in the collection.
     *
     * @return int
     */
    public function count(): int {
        return count($this->registeredFields);
    }

    /**
     * Check if the collection is empty.
     *
     * @return bool
     */
    public function isEmpty(): bool {
        return empty($this->registeredFields);
    }
}
