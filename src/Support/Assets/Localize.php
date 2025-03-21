<?php

namespace Vihersalo\BlockThemeCore\Support\Assets;

/**
 *
 *
 * @since      2.0.0
 * @package    Vihersalo\BlockThemeCore\Support\Assets
 * @author     Heikki Vihersalo <heikki@vihersalo.fi>
 */
class Localize {
	/**
	 * Constructor
	 */
	public function __construct(
		private string $handle,
		private string $object_name,
		private array $l10n
	) {
	}

	/**
	 * Create a new localize object
	 *
	 * @param string $handle The script handle to allow the data to be attached to
	 * @param string $object_name The name of the object (this is the name you will use to access the data in JavaScript)
	 * @param array  $l10n The data to localize the script with
	 * @return self
	 */
	public static function create( string $handle, string $object_name, array $l10n ): self {
		return new self( $handle, $object_name, $l10n );
	}

	/**
	 * Get the handle
	 *
	 * @return string The handle
	 */
	public function get_handle(): string {
		return $this->handle;
	}

	/**
	 * Get the object name
	 *
	 * @return string The object name
	 */
	public function get_object_name(): string {
		return $this->object_name;
	}

	/**
	 * Get the l10n
	 *
	 * @return array The l10n
	 */
	public function get_l10n(): array {
		return $this->l10n;
	}

	/**
	 * Localize the script with the data needed from the server
	 *
	 * @return void
	 */
	public function register(): void {
		wp_localize_script( $this->handle, $this->object_name, $this->l10n );
	}
}
