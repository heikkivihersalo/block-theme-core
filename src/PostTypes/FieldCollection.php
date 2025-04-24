<?php

declare(strict_types=1);

namespace Vihersalo\Core\PostTypes;

class FieldCollection {
    /**
     * The items in the collection.
     * @var array
     */
    private $items = [];

    /**
     * Constructor
     * @return void
     */
    public function __construct() {
    }

    /**
     * Add a text field to the collection.
     *
     * @param string $id The field ID.
     * @param string $label The field label.
     * @return void
     */
    public function addText(string $id, string $label): void {
        $this->items[] = [
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
        $this->items[] = [
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
        $this->items[] = [
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
        $this->items[] = [
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
        $this->items[] = [
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
        $this->items[] = [
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
        $this->items[] = [
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
        $this->items[] = [
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
        $this->items[] = [
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
        $this->items[] = [
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
        $this->items[] = [
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
        $this->items[] = [
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
        $this->items[] = [
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
        $this->items[] = [
            'id'       => $id,
            'label'    => $label,
            'type'     => 'taxonomy-select',
            'taxonomy' => $taxonomy,
        ];
    }

    /**
     * Get all items in the collection.
     *
     * @return array
     */
    public function all(): array {
        return $this->items;
    }

    /**
     * Get the number of items in the collection.
     *
     * @return int
     */
    public function count(): int {
        return count($this->items);
    }

    /**
     * Check if the collection is empty.
     *
     * @return bool
     */
    public function isEmpty(): bool {
        return empty($this->items);
    }
}
