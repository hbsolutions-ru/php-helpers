<?php declare(strict_types=1);

namespace HBS\Helpers;

use HBS\Helpers\Exception\UnexpectedValueException;

final class FileSystemHelper
{
    public static function buildPath(array $parts): string
    {
        if (count($parts) === 0) {
            throw new UnexpectedValueException('Parts could not be empty array');
        }

        if (count($parts) === 1) {
            return reset($parts);
        }

        $parts = array_values($parts);

        $first = rtrim((string)(array_shift($parts) ?: ''), DIRECTORY_SEPARATOR);
        $last = ltrim((string)(array_pop($parts) ?: ''), DIRECTORY_SEPARATOR);

        $parts = array_map(function ($item) {
            return trim((string)$item, DIRECTORY_SEPARATOR);
        }, $parts);

        array_unshift($parts, $first);
        array_push($parts, $last);

        return implode(DIRECTORY_SEPARATOR, $parts);
    }
}
