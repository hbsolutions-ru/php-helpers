<?php declare(strict_types=1);

namespace Tests;

use PHPUnit\Framework\TestCase;
use HBS\Helpers\UuidHelper;

final class UuidHelperTest extends TestCase
{
    public function testValidateFormatV4(): void
    {
        // Positive
        $this->assertTrue(UuidHelper::validateFormatV4("02bb3f44-ae9a-48e2-ba4f-4854c126f381"));
        $this->assertTrue(UuidHelper::validateFormatV4("5b952516-694f-4eb4-8668-acc5781c21e3"));
        $this->assertTrue(UuidHelper::validateFormatV4("94cbe17a-6d50-4eb6-88aa-46d3f27d6ac8"));
        $this->assertTrue(UuidHelper::validateFormatV4("e5a72c76-ec73-424b-89b4-98b48f9aad20"));

        // Negative: non-hex symbols
        $this->assertFalse(UuidHelper::validateFormatV4("8fbab1b3-b0a9-49fg-ac38-93ba5ab626d1"));

        // Negative: unexpected symbol
        $this->assertFalse(UuidHelper::validateFormatV4("aeb7c667-2bdf-4174-7db2-6cf82f437142"));

        // Negative: unexpected separator place
        $this->assertFalse(UuidHelper::validateFormatV4("bb5fda89-72f4-4dab-87d93c-d0f2e6d45b"));

        // Negative: UUID v1
        $this->assertFalse(UuidHelper::validateFormatV4("69b3c3ea-27af-11ed-a261-0242ac120002"));
    }
}
