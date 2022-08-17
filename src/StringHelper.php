<?php declare(strict_types=1);

namespace HBS\Helpers;

use HBS\Helpers\Exception\UnexpectedValueException;

final class StringHelper
{
    private const BASE62 = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz';

    /**
     * NOTE: Limitation: doesn't work with integers
     *
     * @param string $camelCaseInput
     * @return string
     */
    public static function camelToSnakeCase(string $camelCaseInput): string
    {
        preg_match_all('!([A-Z][A-Z0-9]*(?=$|[A-Z][a-z0-9])|[A-Za-z][a-z0-9]+)!', $camelCaseInput, $matches);
        $words = $matches[0];
        foreach ($words as &$word) {
            $word = $word == strtoupper($word) ? strtolower($word) : lcfirst($word);
        }
        return implode('_', $words);
    }

    /**
     * @param string $separator
     * @param string $string
     * @return string
     */
    public static function getLastPart(string $separator, string $string): string
    {
        // Simulate PHP 8 behavior
        if (empty($separator)) {
            throw new UnexpectedValueException("Argument #1 (\$separator) cannot be empty");
        }

        $parts = explode($separator, $string);

        // Simulate PHP 8 behavior
        if (!is_array($parts)) {
            throw new UnexpectedValueException("explode(): returned not an array");
        }

        return (string)end($parts);
    }

    /**
     * @param $value
     * @return bool
     */
    public static function isNonEmptyString($value): bool
    {
        return is_string($value) && strlen($value);
    }

    /**
     * @param string $kebabCaseInput
     * @return string
     */
    public static function kebabToCamelCase(string $kebabCaseInput): string
    {
        return lcfirst(str_replace('-', '', ucwords($kebabCaseInput, '-')));
    }

    /**
     * @param int $length
     * @return string
     * @throws \Exception
     */
    public static function randomBase62(int $length): string
    {
        $result = '';
        for ($i = 0; $i < $length; $i++) {
            $result .= static::BASE62[random_int(0, 61)];
        }
        return $result;
    }

    /**
     * @param string $value
     * @return string
     */
    public static function removeZeroWidthCharsAndTrim(string $value): string
    {
        return trim(preg_replace( '/[\x{200B}-\x{200D}]/u', '', $value));
    }
}
