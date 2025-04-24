<?php

declare(strict_types=1);

namespace Vihersalo\Core\Support\Utils;

final class Formatting {
    /**
     * This utility class should never be instantiated.
     */
    private function __construct() {
    }

    /**
     * Check if string starts with another string
     * @param string $str String that is checked against
     * @param string $str_to_check String to check
     * @return bool
     */
    private static function startsWith($str, $str_to_check) {
        $len = strlen($str_to_check);

        return (substr($str, 0, $len) === $str_to_check);
    }

    /**
     * Get URI for file
     * @param  string $path Path to append to base path
     * @return string
     */
    public static function trimFilePath(string $path = ''): string {
        return rtrim($this->base_uri, '/\\') . '/' . $path;
    }

    /**
     * Write code on Method
     * @param  string $file String to convert
     * @return string
     */
    public static function camelcaseToKebabcase(string $file) {
        return strtolower(preg_replace('/(?<!^)[A-Z]/', '-$0', $file));
    }

    /**
     * Remove file extension from string
     * @param  string $file String to convert
     * @return string
     */
    public static function removeFileExtension(string $file) {
        return str_replace('.php', '', $file);
    }

    /**
     * Format phone number to Finnish format
     * @param mixed $num Phone number
     * @return string
     */
    public static function formatPhoneNum($num): string {
        /**
         * If number is in correct format, return it
         */
        if (self::startsWith($num, '+358')) {
            return preg_replace('/\s+/', '', $num);
        }

        /**
         * If number is in local format (e.g. 0401234567), format it to Finnish format
         */
        if (self::startsWith($num, '0')) {
            switch ($num) :
                case (self::startsWith($num, '040')):
                    return preg_replace(
                        '/\s+/',
                        '',
                        sprintf(
                            '%s %s %s',
                            '+358' . substr($num, 1, 2),
                            substr($num, 3, 3),
                            substr($num, 6)
                        )
                    );
                case (self::startsWith($num, '050')):
                    return preg_replace(
                        '/\s+/',
                        '',
                        sprintf(
                            '%s %s %s',
                            '+358' . substr($num, 1, 2),
                            substr($num, 3, 3),
                            substr($num, 6)
                        )
                    );
                case (self::startsWith($num, '044')):
                    return preg_replace(
                        '/\s+/',
                        '',
                        sprintf(
                            '%s %s %s',
                            '+358' . substr($num, 1, 2),
                            substr($num, 3, 3),
                            substr($num, 6)
                        )
                    );
                case (self::startsWith($num, '045')):
                    return preg_replace(
                        '/\s+/',
                        '',
                        sprintf(
                            '%s %s %s',
                            '+358' . substr($num, 1, 2),
                            substr($num, 3, 3),
                            substr($num, 6)
                        )
                    );
                case (self::startsWith($num, '09')):
                    return preg_replace(
                        '/\s+/',
                        '',
                        sprintf(
                            '%s %s %s',
                            '+358' . substr($num, 1, 2),
                            substr($num, 3, 3),
                            substr($num, 6)
                        )
                    );
                default:
                    return $num;
            endswitch;
        }

        return $num;
    }
}
