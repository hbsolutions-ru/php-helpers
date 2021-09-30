<?php declare(strict_types=1);

namespace HBS\Helpers;

final class UuidHelper
{
    const UUID4_REGEX = '/^[0-9A-F]{8}-[0-9A-F]{4}-4[0-9A-F]{3}-[89AB][0-9A-F]{3}-[0-9A-F]{12}$/i';

    public static function validateFormatV4(string $uuid): bool
    {
        return preg_match(static::UUID4_REGEX, $uuid) === 1;
    }
}
