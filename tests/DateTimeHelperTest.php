<?php declare(strict_types=1);

namespace Tests;

use PHPUnit\Framework\TestCase;
use HBS\Helpers\DateTimeHelper;

final class DateTimeHelperTest extends TestCase
{
    public function testParseUtcTimeOffset(): void
    {
        $parts = DateTimeHelper::parseUtcTimeOffset('UTC-05:00');

        $this->assertCount(3, $parts);
        $this->assertArrayHasKey(DateTimeHelper::UTC_TIME_OFFSET_SIGN, $parts);
        $this->assertArrayHasKey(DateTimeHelper::UTC_TIME_OFFSET_HOURS, $parts);
        $this->assertArrayHasKey(DateTimeHelper::UTC_TIME_OFFSET_MINUTES, $parts);
    }

    public function testUtcTimeOffsetToSeconds(): void
    {
        $this->assertEquals(
            -19800,
            DateTimeHelper::utcTimeOffsetToSeconds('UTC-05:30')
        );
    }
}
