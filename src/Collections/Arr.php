<?php

declare(strict_types=1);

namespace Vihersalo\Core\Support;

class Arr {
    /**
     * If the given value is not an array and not null, wrap it in one.
     *
     * @param  mixed  $value
     * @return array
     */
    public static function wrap($value) {
        if (null === $value) {
            return [];
        }

        return is_array($value) ? $value : [$value];
    }
}
