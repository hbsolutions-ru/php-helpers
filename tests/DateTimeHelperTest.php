<?php declare(strict_types=1);

namespace Tests;

use PHPUnit\Framework\TestCase;
use HBS\Helpers\DateTimeHelper;

final class DateTimeHelperTest extends TestCase
{
    public function testConvertFormatInUtc(): void
    {
        $dateTime = DateTimeHelper::convertFormatInUtc(
            '2021-12-02 12:34:56',
            'Y-m-d H:i:s',
            'Y-m-d\\TH:i:s\\.v\\Z'
        );

        $this->assertEquals(
            '2021-12-02T12:34:56.000Z',
            $dateTime
        );
    }

    public function testParseUtcTimeOffset(): void
    {
        $parts = DateTimeHelper::parseUtcTimeOffset('UTC-05:00');

        $this->assertCount(3, $parts);

        $this->assertArrayHasKey(DateTimeHelper::UTC_TIME_OFFSET_SIGN, $parts);
        $this->assertArrayHasKey(DateTimeHelper::UTC_TIME_OFFSET_HOURS, $parts);
        $this->assertArrayHasKey(DateTimeHelper::UTC_TIME_OFFSET_MINUTES, $parts);

        $this->assertEquals('-', $parts[DateTimeHelper::UTC_TIME_OFFSET_SIGN]);
        $this->assertEquals(5, $parts[DateTimeHelper::UTC_TIME_OFFSET_HOURS]);
        $this->assertEquals(0, $parts[DateTimeHelper::UTC_TIME_OFFSET_MINUTES]);
    }

    public function testUtcTimeOffsetToSeconds(): void
    {
        $this->assertEquals(
            -19800,
            DateTimeHelper::utcTimeOffsetToSeconds('UTC-05:30')
        );
    }

    public function testValidateFormat(): void
    {
        $this->assertTrue(
            DateTimeHelper::validateFormat('2021-12-02 12:34:56', 'Y-m-d H:i:s')
        );

        $this->assertFalse(
            DateTimeHelper::validateFormat('2021-12-02T12:34:56', 'Y-m-d H:i:s')
        );
    }

    public function testValidateUtcTimeOffset(): void
    {
        $positive = ['UTC±00:00', 'UTC+00:00', 'UTC-00:00', 'UTC-05:00', 'UTC+10:45'];
        foreach ($positive as $utcTimeOffset) {
            $this->assertTrue(
                DateTimeHelper::validateUtcTimeOffset($utcTimeOffset)
            );
        }

        $negative = ['UTC±00:01', 'UTC-20:00', 'UTC+99:99'];
        foreach ($negative as $utcTimeOffset) {
            $this->assertFalse(
                DateTimeHelper::validateUtcTimeOffset($utcTimeOffset)
            );
        }
    }
}
