<?php declare(strict_types=1);

namespace HBS\Helpers;

use HBS\Helpers\Exception\DuplicateKeyException;

final class ArrayHelper
{
    public static function mapKeys(array $subject, array $keysMap): array
    {
        if (!count($keysMap)) {
            return $subject;
        }

        $result = [];
        foreach ($subject as $key => $value) {
            $result[$keysMap[$key] ?? $key] = $value;
        }

        return $result;
    }

    public static function keysFromColumn(array $subject, string $uniqueColumn): array
    {
        $keys = array_column($subject, $uniqueColumn);

        if (count(array_unique($keys, SORT_STRING)) !== count($subject)) {
            throw new DuplicateKeyException('Duplicate values found in the keys column');
        }

        return array_combine($keys, $subject);
    }
}
