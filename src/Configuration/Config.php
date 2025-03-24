<?php

namespace Vihersalo\Core\Configuration;

/**
 *
 * @since      1.0.0
 * @package    Vihersalo\Core\Configuration
 * @author     Heikki Vihersalo <heikki@vihersalo.fi>
 */
class Config {
	/**
	 * The path to the configuration files.
	 * @var string
	 */
	protected $config_path;

	/**
	 * The configuration values.
	 * @var array
	 */
	protected $config = [];

	/**
	 * Constructor
	 */
	public function __construct( $config_path ) {
		$this->config_path = $config_path;
		$this->load_config_files();
	}

	/**
	 * Load the configuration files.
	 */
	protected function load_config_files() {
		$config_files = glob( $this->config_path . '/*.php' );

		foreach ( $config_files as $config_file ) {
			$config_key = basename( $config_file, '.php' );

			$this->config[ $config_key ] = require $config_file;
		}
	}

	/**
	 * Get a configuration value from the configuration array.
	 * Configuration values are dot-separated keys to allow for nested values.
	 *
	 * @param string $key The key of the configuration value
	 */
	public function get( $key ) {
		$keys = explode( '.', $key );

		// Get the configuration value from the configuration array using the keys
		switch ( count( $keys ) ) {
			case 1:
				return $this->config[ $keys[0] ] ?? null;
			case 2:
				return $this->config[ $keys[0] ][ $keys[1] ] ?? null;
			case 3:
				return $this->config[ $keys[0] ][ $keys[1] ][ $keys[2] ] ?? null;
		}

		return null;
	}
}
