<?php

declare(strict_types=1);

namespace Vihersalo\Core\Support;

abstract class SettingsModel {
    /**
     * The database ID for the settings.
     *
     * @var string
     */
    protected string $id;

    /**
     * The keys for the settings
     *
     * @var string
     */
    protected array $keys;

    /**
     * Constructor
     */
    public function __construct() {
        // Set the ID depending on the calling class
        if (empty($this->id)) {
            $this->id = $this->resolveDatabaseID();
        }

        // Set the keys depending on the calling class
        if (empty($this->keys)) {
            $this->keys = $this->resolveDatabaseKeys();
        }
    }

    /**
     * Get the database ID
     *
     * @return string The database ID.
     */
    public function id(): string {
        return $this->id;
    }

    /**
     * Get the database keys
     *
     * @return array The database keys.
     */
    public function keys(): array {
        return $this->keys;
    }

    /**
     * Set the database ID based on the class name.
     *
     * @return string The database ID.
     */
    public function resolveDatabaseID() {
        return \strtolower(\str_replace('\\', '-', \get_class($this)));
    }

    /**
     * Set the database keys based on the default value keys.
     *
     * @return array The database keys.
     */
    public function resolveDatabaseKeys() {
        foreach ($this->default() as $key => $value) {
            $keys[] = $key;
        }

        return $keys ?? [];
    }

    /**
     * Sanitize the array values.
     *
     * @param array $body The request body to sanitize.
     * @return array Sanitized array
     */
    public function sanitize(array $body): array {
        $sanitized = [];

        foreach ($this->keys() as $key) {
            if (isset($data[$key])) {
                $sanitized[$key] = \sanitize_text_field($data[$key]);
            }
        }

        return $sanitized;
    }

    /**
     * Get the settings.
     *
     * @return array The settings.
     */
    public function all(): array {
        return \get_option($this->id(), $this->default());
    }

    /**
     * Get individual setting.
     *
     * @param string $key The key to get.
     * @return mixed The value of the key.
     */
    public function get(string $key): mixed {
        $current = \get_option($this->id(), $this->default()) ?: [];

        if (! \array_key_exists($key, $current)) {
            throw new Exception('Invalid key.', 400);
        }

        return $current[$key];
    }

    /**
     * Save the settings.
     *
     * @param array $values The values to save.
     * @return array The settings.
     */
    public function save(array $values): array {
        if (empty($values)) {
            throw new Exception('Invalid values.', 400);
        }

        // Save the settings to the database.
        $updated = \update_option($this->id(), $this->sanitize($values));

        if (! $updated) {
            throw new \Exception('Failed to update analytics settings.', 500);
        }

        // Return the updated settings.
        return $values;
    }

    /**
     * Get the setting default values.
     *
     * @return array The default values.
     */
    abstract public function default(): array;
}
