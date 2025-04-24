<?php

declare(strict_types=1);

namespace Vihersalo\Core\PostTypes;

/**
 * Utility functions
 *
 * @since      0.1.0
 * @package    Kotisivu\BlockTheme\Theme\Common\Utils
 * @author     Heikki Vihersalo <heikki@vihersalo.fi>
 */
final class Utils {
    /**
     * This utility class should never be instantiated.
     */
    private function __construct() {
    }

    /**
     * Write code on Method
     *
     * @since 0.1.0
     * @access public
     * @param  string $file String to convert
     * @return string
     */
    public static function camelcaseToKebabcase(string $file) {
        return strtolower(preg_replace('/(?<!^)[A-Z]/', '-$0', $file));
    }

    /**
     * Remove file extension from string
     *
     * @since 0.1.0
     * @access public
     * @param  string $file String to convert
     * @return string
     */
    public static function removeFileExtension(string $file) {
        return str_replace('.php', '', $file);
    }
}
