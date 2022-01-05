<?php declare(strict_types=1);

namespace HBS\Helpers;

use DateTime;
use DateTimeZone;

final class DateTimeHelper
{
    private const HOUR = 3600;
    private const MINUTE = 60;

    private const DATE_TIME_ZONE_UTC = 'UTC';

    private const UTC_TIME_OFFSET_REGEX = '/^UTC(?P<sign>[\x{00B1}+-])(?P<hours>[01]\d):(?P<minutes>[0-5]\d)$/u';

    public const UTC_TIME_OFFSET_SIGN = 'sign';
    public const UTC_TIME_OFFSET_HOURS = 'hours';
    public const UTC_TIME_OFFSET_MINUTES = 'minutes';

    public static function convertFormatInUtc(string $date, string $inputFormat, string $outputFormat): string
    {
        $dateTime = DateTime::createFromFormat($inputFormat, $date, new DateTimeZone(static::DATE_TIME_ZONE_UTC));
        return $dateTime->format($outputFormat);
    }

    public static function parseUtcTimeOffset(string $offset): ?array
    {
        $success = preg_match(static::UTC_TIME_OFFSET_REGEX, $offset, $matches) === 1;

        if (!$success) {
            return null;
        }

        return [
            static::UTC_TIME_OFFSET_SIGN => $matches['sign'],
            static::UTC_TIME_OFFSET_HOURS => intval($matches['hours']),
            static::UTC_TIME_OFFSET_MINUTES => intval($matches['minutes']),
        ];
    }

    public static function secondsToHumanReadableTimeInterval(int $seconds): string
    {
        return sprintf(
            '%s%02d:%02d:%02d',
            $seconds < 0 ? '-' : '',
            intval(abs($seconds) / 3600),
            intval(abs($seconds) / 60 % 60),
            intval(abs($seconds) % 60)
        );
    }

    public static function utcTimeOffsetToSeconds(string $offset): int
    {
        $parts = static::parseUtcTimeOffset($offset);

        if (!$parts) {
            return 0;
        }

        [
            static::UTC_TIME_OFFSET_SIGN => $sign,
            static::UTC_TIME_OFFSET_HOURS => $hours,
            static::UTC_TIME_OFFSET_MINUTES => $minutes,
        ] = $parts;

        return ($sign === '-' ? -1 : 1) * ($hours * static::HOUR + $minutes * static::MINUTE);
    }

    public static function validateFormat(string $date, string $format = 'Y-m-d H:i:s'): bool
    {
        $dt = DateTime::createFromFormat($format, $date);
        return $dt !== false && !array_sum($dt::getLastErrors()) && $dt->format($format) === $date;
    }

    public static function validateUtcTimeOffset(string $offset): bool
    {
        $parts = static::parseUtcTimeOffset($offset);

        if (!$parts) {
            return false;
        }

        [
            static::UTC_TIME_OFFSET_SIGN => $sign,
            static::UTC_TIME_OFFSET_HOURS => $hours,
            static::UTC_TIME_OFFSET_MINUTES => $minutes,
        ] = $parts;

        if (preg_match('/^\x{00B1}$/u', $sign) === 1 && !($hours === 0 && $minutes === 0)) {
            return false;
        }

        return true;
    }
}
