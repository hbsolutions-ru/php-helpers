<?php declare(strict_types=1);

namespace HBS\Helpers;

final class ObjectHelper
{
    public static function toArray($object, array $mutedFields = []): array
    {
        $array = json_decode(json_encode($object), true);
        foreach ($mutedFields as $field) {
            if (isset($array[$field]) || $array[$field] === null) {
                unset($array[$field]);
            }
        }
        return $array;
    }

    public static function objectsToArray(array $objects, array $mutedFields = [])
    {
        return array_map(function ($object) use ($mutedFields) {
            return self::toArray($object, $mutedFields);
        }, $objects);
    }
}
