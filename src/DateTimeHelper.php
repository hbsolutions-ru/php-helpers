<?php declare(strict_types=1);

namespace HBS\Helpers;

use DateTime;

final class DateTimeHelper
{
    public static function validateFormat(string $date, string $format = 'Y-m-d'): bool
    {
        $dt = DateTime::createFromFormat($format, $date);
        return $dt !== false && !array_sum($dt::getLastErrors()) && $dt->format($format) === $date;
    }
}
