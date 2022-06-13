<?php declare(strict_types=1);

namespace HBS\Helpers;

use HBS\Helpers\Exception\{
    DuplicateKeyException,
    InconsistencyException
};

final class ArrayHelper
{
    public static function filterNulls(array $array): array
    {
        return array_filter($array, function ($item) {
            return $item !== null;
        });
    }

    public static function flatten(array $array, int $rowLength = 0): array
    {
        $arraysCount = array_reduce($array, function($carry, $item) {
            return $carry + (is_array($item) ? 1 : 0);
        }, 0);

        if (count($array) !== $arraysCount) {
            throw new InconsistencyException('Array should contains only arrays, to be flatten');
        }

        if ($rowLength > 0) {
            foreach ($array as $set) {
                if (count($set) !== $rowLength) {
                    throw new InconsistencyException('One of the inner arrays is the wrong size');
                }
            }
        }

        return array_merge(...$array);
    }

    public static function keysFromColumn(array $array, string $uniqueColumn): array
    {
        $keys = array_column($array, $uniqueColumn);

        if (count(array_unique($keys, SORT_STRING)) !== count($array)) {
            throw new DuplicateKeyException('Duplicate values found in the keys column');
        }

        return array_combine($keys, $array);
    }

    public static function mapKeys(array $array, array $keysMap): array
    {
        if (!count($keysMap)) {
            return $array;
        }

        $result = [];
        foreach ($array as $key => $value) {
            $result[$keysMap[$key] ?? $key] = $value;
        }

        return $result;
    }

    public static function removeAllItemsWithValue(array &$array, $value): int
    {
        $count = 0;

        foreach (array_keys($array, $value, true) as $key) {
            unset($array[$key]);
            $count++;
        }

        return $count;
    }
}
