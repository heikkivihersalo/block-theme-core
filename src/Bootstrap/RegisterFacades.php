<?php

declare(strict_types=1);

namespace Vihersalo\Core\Bootstrap;

use Vihersalo\Core\Support\Facades\Facade;

class RegisterFacades {
    /**
     * Bootstrap the given application.
     *
     * @param  Application  $app
     * @return void
     */
    public function bootstrap(Application $app) {
        Facade::clearResolvedInstances();

        Facade::setFacadeApplication($app);

        AliasLoader::getInstance($app->make('config')->get('app.aliases', []))->register();
    }
}
