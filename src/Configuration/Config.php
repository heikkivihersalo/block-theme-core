<?php

declare(strict_types=1);

namespace Vihersalo\Core\Configuration;

class Config {
    /**
     * The path to the configuration files.
     * @var string
     */
    protected $configPath;

    /**
     * The configuration values.
     * @var array
     */
    protected $config = [];

    /**
     * Constructor
     * @param string $configPath The path to the configuration files
     * @return void
     */
    public function __construct($configPath) {
        $this->configPath = $configPath;
        $this->loadConfigFiles();
    }

    /**
     * Load the configuration files.
     * @return void
     */
    protected function loadConfigFiles() {
        $config_files = glob($this->configPath . '/*.php');

        foreach ($config_files as $config_file) {
            $config_key = basename($config_file, '.php');

            $this->config[ $config_key ] = require $config_file;
        }
    }

    /**
     * Get a configuration value from the configuration array.
     * Configuration values are dot-separated keys to allow for nested values.
     * @param string $key The key of the configuration value
     * @return mixed
     */
    public function get($key) {
        $keys = explode('.', $key);

        // Get the configuration value from the configuration array using the keys
        switch (count($keys)) {
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
