<?php

declare(strict_types=1);

namespace Vihersalo\Core\Configuration;

class FileLoader {
    /**
     * The path to the configuration files.
     * @var string
     */
    protected $path;

    /**
     * The container for the configuration values.
     * @var array
     */
    protected $container = [];

    /**
     * Constructor
     * @param string $path The path to the configuration files
     * @return void
     */
    public function __construct($path) {
        $this->path = $path;
        $this->load();
    }

    /**
     * Load the configuration files.
     * @return void
     */
    protected function load() {
        $files = glob($this->configPath . '/*.php');

        foreach ($files as $file) {
            $key = basename($file, '.php');

            $this->config[ $key ] = require $file;
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
