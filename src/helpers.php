<?php

declare(strict_types=1);

namespace Vihersalo\Core\Application {
    use Illuminate\Config\Repository;
    use Illuminate\Container\Container;
    use Illuminate\Foundation\Application;

    if (! function_exists('app')) {
        /**
         * Get the available container instance.
         *
         * @template TClass of object
         *
         * @param  string|class-string<TClass>|null $abstract
         * @param  array                            $parameters
         * @return ($abstract is class-string<TClass> ? TClass : ($abstract is null ? Application : mixed))
         */
        function app($abstract = null, array $parameters = []) {
            if (null === $abstract) {
                return Container::getInstance();
            }

            return Container::getInstance()->make($abstract, $parameters);
        }
    }

    if (! function_exists('config')) {
        /**
         * Get / set the specified configuration value.
         *
         * If an array is passed as the key, we will assume you want to set an array of values.
         *
         * @param  array<string, mixed>|string|null $key
         * @param  mixed                            $default
         * @return ($key is null ? Repository : ($key is string ? mixed : null))
         */
        function config($key = null, $default = null) {
            if (null === $key) {
                return app('config');
            }

            if (is_array($key)) {
                return app('config')->set($key);
            }

            return app('config')->get($key, $default);
        }
    }

    if (! function_exists('wp_loader')) {
        /**
         * Get the hooks loader instance
         *
         * @return WP_Hooks
         */
        function wp_loader() {
            return app(WP_Hooks::class);
        }
    }
}
