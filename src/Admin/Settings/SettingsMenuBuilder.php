<?php

namespace Vihersalo\BlockThemeCore\Admin\Settings;

use Vihersalo\BlockThemeCore\Support\Assets\Localize;

/**
 * Application builder
 *
 * @since      2.0.0
 * @package    Vihersalo\BlockThemeCore\Application
 * @author     Heikki Vihersalo <heikki@vihersalo.fi>
 */
class SettingsMenuBuilder {
	/**
	 * Constructor
	 *
	 * @return void
	 */
	public function __construct( protected SettingsMenu $menu ) {
	}

	/**
	 * Build the submenu from the user callback function
	 *
	 * @param callable|null $callback The user callback function
	 * @return self
	 */
	public function with_submenu( ?callable $callback = null ) {
		$submenu = new Collections\MenuCollection();

		if ( ! $callback ) {
			return $this;
		}

		$callback( $submenu );

		$this->menu->set_submenu( $submenu->get() );

		return $this;
	}

	/**
	 * Build the assets from the user callback function
	 *
	 * @param callable|null $callback The user callback function
	 * @return self
	 */
	public function with_assets( ?callable $callback = null ) {
		$assets = new Collections\AssetCollection();

		if ( ! $callback ) {
			return $this;
		}

		$callback( $assets );

		$this->menu->set_assets( $assets->get() );

		return $this;
	}

	/**
	 * Build the localize from the user callback function
	 *
	 * @param string $handle The script handle to allow the data to be attached to
	 * @param string $object_name The name of the object (this is the name you will use to access the data in JavaScript)
	 * @param array  $l10n The data to localize the script with
	 * @return self
	 */
	public function with_localize( string $handle, string $object_name, array $l10n ) {
		$this->menu->set_localize( Localize::create( $handle, $object_name, $l10n ) );
		return $this;
	}

	/**
	 * Create a new settings menu
	 *
	 * @return SettingsMenu
	 */
	public function create() {
		return $this->menu;
	}
}
