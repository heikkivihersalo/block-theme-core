<?php

namespace Vihersalo\Core\Bootstrap;

use Vihersalo\Core\Support\Facades\Facade;

class RegisterFacades {
    /**
     * Bootstrap the given application.
     *
     * @param  \Vihersalo\Core\Bootstrap\Application  $app
     * @return void
     */
    public function bootstrap(Application $app) {
        Facade::clearResolvedInstances();

        Facade::setFacadeApplication($app);

        AliasLoader::getInstance($app->make('config')->get('app.aliases', []))->register();
    }
}
