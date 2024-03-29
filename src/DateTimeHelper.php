<?php declare(strict_types=1);

namespace HBS\Helpers;

use DateTimeImmutable;
use DateTimeZone;

use function abs;
use function array_sum;
use function intval;
use function microtime;
use function number_format;
use function preg_match;
use function sprintf;
use function var_dump;

final class DateTimeHelper
{
    private const HOUR = 3600;
    private const MINUTE = 60;

    private const DATE_TIME_ZONE_UTC = 'UTC';

    private const UTC_TIME_OFFSET_REGEX = '/^UTC(?P<sign>[\x{00B1}+-])(?P<hours>[01]\d):(?P<minutes>[0-5]\d)$/u';

    public const UTC_TIME_OFFSET_SIGN = 'sign';
    public const UTC_TIME_OFFSET_HOURS = 'hours';
    public const UTC_TIME_OFFSET_MINUTES = 'minutes';

    public static function convertFormat(
        string $date,
        string $inputFormat,
        string $outputFormat,
        string $timeZone = self::DATE_TIME_ZONE_UTC
    ): string
    {
        return (DateTimeImmutable::createFromFormat(
            $inputFormat,
            $date,
            new DateTimeZone($timeZone)
        ))
            ->format($outputFormat);
    }

    /**
     * @deprecated Use DateTimeHelper::convertFormat instead.
     */
    public static function convertFormatInUtc(string $date, string $inputFormat, string $outputFormat): string
    {
        return self::convertFormat($date, $inputFormat, $outputFormat, self::DATE_TIME_ZONE_UTC);
    }

    public static function now(string $timeZone = self::DATE_TIME_ZONE_UTC): DateTimeImmutable
    {
        return DateTimeImmutable::createFromFormat(
            'U.u',
            number_format(microtime(true), 6, '.', ''),
            new DateTimeZone($timeZone)
        );
    }

    public static function parseUtcTimeOffset(string $offset): ?array
    {
        $success = preg_match(self::UTC_TIME_OFFSET_REGEX, $offset, $matches) === 1;

        if (!$success) {
            return null;
        }

        return [
            self::UTC_TIME_OFFSET_SIGN => $matches['sign'],
            self::UTC_TIME_OFFSET_HOURS => intval($matches['hours']),
            self::UTC_TIME_OFFSET_MINUTES => intval($matches['minutes']),
        ];
    }

    public static function secondsToHumanReadableTimeInterval(int $seconds): string
    {
        return sprintf(
            '%s%02d:%02d:%02d',
            $seconds < 0 ? '-' : '',
            intval(abs($seconds) / 3600),
            intval(abs($seconds) / 60) % 60,
            abs($seconds) % 60
        );
    }

    public static function timestampToDateTime(int $timestamp): DateTimeImmutable
    {
        return DateTimeImmutable::createFromFormat(
            'U',
            (string)$timestamp,
            new DateTimeZone(self::DATE_TIME_ZONE_UTC)
        );
    }

    public static function utcTimeOffsetToSeconds(string $offset): int
    {
        $parts = self::parseUtcTimeOffset($offset);

        if (!$parts) {
            return 0;
        }

        [
            self::UTC_TIME_OFFSET_SIGN => $sign,
            self::UTC_TIME_OFFSET_HOURS => $hours,
            self::UTC_TIME_OFFSET_MINUTES => $minutes,
        ] = $parts;

        return ($sign === '-' ? -1 : 1) * ($hours * self::HOUR + $minutes * self::MINUTE);
    }

    public static function validateFormat(string $date, string $format = 'Y-m-d H:i:s'): bool
    {
        $dt = DateTimeImmutable::createFromFormat($format, $date);
        return $dt !== false && !array_sum($dt::getLastErrors()) && $dt->format($format) === $date;
    }

    public static function validateUtcTimeOffset(string $offset): bool
    {
        $parts = self::parseUtcTimeOffset($offset);

        if (!$parts) {
            return false;
        }

        [
            self::UTC_TIME_OFFSET_SIGN => $sign,
            self::UTC_TIME_OFFSET_HOURS => $hours,
            self::UTC_TIME_OFFSET_MINUTES => $minutes,
        ] = $parts;

        if (preg_match('/^\x{00B1}$/u', $sign) === 1 && !($hours === 0 && $minutes === 0)) {
            return false;
        }

        return true;
    }
}
