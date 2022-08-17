<?php declare(strict_types=1);

namespace Tests;

use PHPUnit\Framework\TestCase;
use HBS\Helpers\StringHelper;

final class StringHelperTest extends TestCase
{
    public function testCamelToSnakeCase(): void
    {
        $result = StringHelper::camelToSnakeCase("helloWorld");
        $this->assertEquals("hello_world", $result);

        $result = StringHelper::camelToSnakeCase("theQuickBrownFoxJumpsOverTheLazyDog");
        $this->assertEquals("the_quick_brown_fox_jumps_over_the_lazy_dog", $result);
    }

    public function testGetLastPart(): void
    {
        $string = "The quick brown fox jumps over the lazy dog";

        $result = StringHelper::getLastPart("g", $string);
        $this->assertEquals("", $result);

        $result = StringHelper::getLastPart("o", $string);
        $this->assertEquals("g", $result);

        $result = StringHelper::getLastPart(" ", $string);
        $this->assertEquals("dog", $result);

        $result = StringHelper::getLastPart("e", $string);
        $this->assertEquals(" lazy dog", $result);
    }
}
