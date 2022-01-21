<?php declare(strict_types=1);

namespace HBS\Helpers;

use HBS\Helpers\Exception\UnexpectedValueException;

final class FileSystemHelper
{
    private const DEFAULT_FILENAME_LENGTH = 16;
    private const DIR_MODE = 0777;

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

    public static function createPath(string $fullPath): bool
    {
        $dir = dirname($fullPath);

        if (is_dir($dir)) {
            return true;
        }

        return mkdir($dir, self::DIR_MODE, true);
    }

    public static function generateFilename(
        $pathPrefix = '',
        ?string $fileExtension = null,
        int $nameLength = self::DEFAULT_FILENAME_LENGTH
    ): string
    {
        $pathPrefix = $pathPrefix ?: '';

        if (is_array($pathPrefix)) {
            $pathPrefix = self::buildPath($pathPrefix);
        }

        $filename = StringHelper::randomBase62($nameLength) . ($fileExtension === null ? '' : '.' . $fileExtension);

        return self::buildPath([
            $pathPrefix,
            $filename,
        ]);
    }
}
