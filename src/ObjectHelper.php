<?php declare(strict_types=1);

namespace HBS\Helpers;

use ReflectionClass;
use HBS\Helpers\Exception\ClassNotFound;

final class ObjectHelper
{
    /**
     * @param object $object
     * @param string $className
     * @return object
     */
    public static function castWithPublicProperties($object, string $className)
    {
        $reflectionClass = self::getReflectionClass($className);
        $properties = $reflectionClass->getProperties();
        $result = $reflectionClass->newInstance();

        foreach($properties as $property) {
            $propertyName = $property->getName();
            if ($property->isPublic() && isset($object->{$propertyName})) {
                $property->setValue($result, $object->{$propertyName});
            }
        }

        return $result;
    }

    /**
     * @param array $objects
     * @param string $propertyName
     * @return int[]
     */
    public static function extractIds(array $objects, string $propertyName = 'id'): array
    {
        return array_map('intval', array_column($objects, $propertyName));
    }

    /**
     * @param array $fieldsMap
     * @param string $className
     * @return object
     */
    public static function hydrateFromArray(array $fieldsMap, string $className)
    {
        $reflectionClass = self::getReflectionClass($className);
        $properties = $reflectionClass->getProperties();
        $result = $reflectionClass->newInstance();

        foreach($properties as $property) {
            $propertyName = $property->getName();
            if ($property->isPublic() && isset($fieldsMap[$propertyName])) {
                $property->setValue($result, $fieldsMap[$propertyName]);
            }
        }

        return $result;
    }

    /**
     * @param object|string $objectOrClassName
     * @param string $interfaceName
     * @return bool
     */
    public static function implementsInterface($objectOrClassName, string $interfaceName): bool
    {
        return self::getReflectionClass($objectOrClassName)->implementsInterface($interfaceName);
    }

    /**
     * @param array $objects
     * @param string[] $mutedFields
     * @return array
     */
    public static function objectsToArray(array $objects, array $mutedFields = []): array
    {
        return array_map(function ($object) use ($mutedFields) {
            return self::toArray($object, $mutedFields);
        }, $objects);
    }

    /**
     * @param object $object
     * @param string[] $mutedFields
     * @return array
     */
    public static function toArray($object, array $mutedFields = []): array
    {
        $array = json_decode(json_encode($object), true);
        foreach ($mutedFields as $field) {
            if (array_key_exists($field, $array)) {
                unset($array[$field]);
            }
        }
        return $array;
    }

    /**
     * @param object|string $objectOrClassName
     * @return ReflectionClass
     */
    private static function getReflectionClass($objectOrClassName): ReflectionClass
    {
        if (!(
            is_string($objectOrClassName) || is_object($objectOrClassName)
        )) {
            throw new \InvalidArgumentException("Object or class name (string) argument expected");
        }

        try {
            return new ReflectionClass($objectOrClassName);
        } catch (\ReflectionException $e) {
            $className = is_string($objectOrClassName)
                ? (string)$objectOrClassName
                : get_class($objectOrClassName);

            throw new ClassNotFound(
                sprintf("Class '%s' not found; Reason: %s", $className, $e->getMessage()),
                $e->getCode(), $e
            );
        }
    }
}
