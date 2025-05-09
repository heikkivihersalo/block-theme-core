<?php

declare(strict_types=1);

namespace Vihersalo\Core\Support\Facades;

use Closure;
use Illuminate\Support\Collection;
use RuntimeException;
use Vihersalo\Core\Foundation\Application;

abstract class Facade {
    /**
     * The application instance being facaded.
     *
     * @var Application|null
     */
    protected static $app;

    /**
     * The resolved object instances.
     *
     * @var array
     */
    protected static $resolvedInstance;

    /**
     * Run a Closure when the facade has been resolved.
     *
     * @param  Closure  $callback
     * @return void
     */
    public static function resolved(Closure $callback) {
        $accessor = static::getFacadeAccessor();

        if (static::$app->resolved($accessor) === true) {
            $callback(static::getFacadeRoot(), static::$app);
        }

        static::$app->afterResolving($accessor, function ($service, $app) use ($callback) {
            $callback($service, $app);
        });
    }

    /**
     * Get the root object behind the facade.
     *
     * @return mixed
     */
    public static function getFacadeRoot() {
        return static::resolveFacadeInstance(static::getFacadeAccessor());
    }

    /**
     * Get the registered name of the component.
     *
     * @return string
     *
     * @throws RuntimeException
     */
    protected static function getFacadeAccessor() {
        throw new RuntimeException('Facade does not implement getFacadeAccessor method.');
    }

    /**
     * Resolve the facade root instance from the container.
     *
     * @param  string  $name
     * @return mixed
     */
    protected static function resolveFacadeInstance($name) {
        if (isset(static::$resolvedInstance[$name])) {
            return static::$resolvedInstance[$name];
        }

        if (static::$app) {
            // if (static::$cached) {
            //     return static::$resolvedInstance[$name] = static::$app[$name];
            // }

            return static::$app[$name];
        }
    }

    /**
     * Clear a resolved facade instance.
     *
     * @param  string  $name
     * @return void
     */
    public static function clearResolvedInstance($name) {
        unset(static::$resolvedInstance[$name]);
    }

    /**
     * Clear all of the resolved instances.
     *
     * @return void
     */
    public static function clearResolvedInstances() {
        static::$resolvedInstance = [];
    }

    /**
     * Get the application default aliases.
     *
     * @return Collection
     */
    public static function defaultAliases() {
        return [
            'App'      => App::class,
            'Asset'    => Asset::class,
            'Route'    => Route::class,
            'Settings' => Settings::class,
            'Store'    => Store::class,
        ];
    }

    /**
     * Get the application instance behind the facade.
     *
     * @return \Illuminate\Contracts\Foundation\Application|null
     */
    public static function getFacadeApplication() {
        return static::$app;
    }

    /**
     * Set the application instance.
     *
     * @param  \Illuminate\Contracts\Foundation\Application|null  $app
     * @return void
     */
    public static function setFacadeApplication($app) {
        static::$app = $app;
    }

    /**
     * Handle dynamic, static calls to the object.
     *
     * @param  string  $method
     * @param  array  $args
     * @return mixed
     *
     * @throws RuntimeException
     */
    public static function __callStatic($method, $args) {
        $instance = static::getFacadeRoot();

        if (! $instance) {
            throw new RuntimeException('A facade root has not been set.');
        }

        return $instance->$method(...$args);
    }
}
