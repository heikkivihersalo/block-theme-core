<?php

declare(strict_types=1);

namespace Vihersalo\Core\Support;

use Vihersalo\Core\Foundation\Application;
use Vihersalo\Core\Foundation\HooksStore;

abstract class Handler {
    /**
     * Store instance
     * @var HooksStore
     */
    protected HooksStore $store;

    /**
     * Constructor
     */
    public function __construct(protected Application $app) {
        $this->store = $this->app->make(HooksStore::class);
    }

    /**
     * Handle the logic
     * @return void
     */
    abstract public function handle(): void;
}
