<?php

declare(strict_types=1);

namespace Vihersalo\Core\Support\Collections;

use Vihersalo\Core\Support\Handler;

class HandlerCollection {
    /**
     * Array of handlers to be executed
     * @var array $handlers The handlers
     */
    private $handlers = [];

    /**
     * Constructor
     * @return void
     */
    public function __construct() {
    }

    /**
     * Add new handler to the collection. Can be either a single handler or an array of handlers.
     * @param Handler|array
     * @return self
     */
    public function add($handler) {
        if (is_array($handler)) {
            foreach ($handler as $a) {
                if ($a instanceof Asset) {
                    $this->assets[] = $a;
                }
            }

            return $this;
        }

        if ($handler instanceof Handler) {
            $this->handlers[] = $handler;
        }

        return $this;
    }

    /**
     * Get all handlers
     * @return Handler[] The handlers
     */
    public function all() {
        return $this->handlers;
    }
}
