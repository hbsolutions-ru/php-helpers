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

    public function testNow(): void
    {
        $now = DateTimeHelper::now();
        $expected = date('Y-m-d H:i:s');

        $this->assertEquals(
            $expected,
            $now->format('Y-m-d H:i:s')
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

    public function testSecondsToHumanReadableTimeInterval()
    {
        $this->assertEquals(
            '00:20:34',
            DateTimeHelper::secondsToHumanReadableTimeInterval(1234)
        );

        $this->assertEquals(
            '01:34:38',
            DateTimeHelper::secondsToHumanReadableTimeInterval(5678)
        );

        $this->assertEquals(
            '00:00:00',
            DateTimeHelper::secondsToHumanReadableTimeInterval(0)
        );

        $this->assertEquals(
            '-00:01:07',
            DateTimeHelper::secondsToHumanReadableTimeInterval(-67)
        );

        $this->assertEquals(
            '-01:30:32',
            DateTimeHelper::secondsToHumanReadableTimeInterval(-5432)
        );

        $this->assertEquals(
            '291:16:16',
            DateTimeHelper::secondsToHumanReadableTimeInterval(1048576)
        );
    }

    public function testTimestampToDateTime(): void
    {
        $dateTime = DateTimeHelper::timestampToDateTime(1680307200);

        $this->assertEquals("2023-04-01T00:00:00", $dateTime->format("Y-m-d\\TH:i:s"));
        $this->assertEquals(0, $dateTime->getOffset());
        $this->assertEquals("+00:00", $dateTime->getTimezone()->getName());
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
