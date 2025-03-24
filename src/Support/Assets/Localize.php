<?php

declare(strict_types=1);

namespace Vihersalo\Core\Support\Assets;

class Localize {
    /**
     * Constructor
     */
    public function __construct(
        private string $handle,
        private string $objectName,
        private array $l10n
    ) {
    }

    /**
     * Create a new localize object
     * @param string $handle The script handle to allow the data to be attached to
     * @param string $objectName The name of the object
     *               (this is the name you will use to access the data in JavaScript)
     * @param array  $l10n The data to localize the script with
     * @return self
     */
    public static function create(string $handle, string $objectName, array $l10n): self {
        return new self($handle, $objectName, $l10n);
    }

    /**
     * Get the handle
     * @return string The handle
     */
    public function getHandle(): string {
        return $this->handle;
    }

    /**
     * Get the object name
     * @return string The object name
     */
    public function getObjectName(): string {
        return $this->objectName;
    }

    /**
     * Get the l10n
     *
     * @return array The l10n
     */
    public function getL10n(): array {
        return $this->l10n;
    }

    /**
     * Localize the script with the data needed from the server
     *
     * @return void
     */
    public function register(): void {
        wp_localize_script($this->handle, $this->objectName, $this->l10n);
    }
}
