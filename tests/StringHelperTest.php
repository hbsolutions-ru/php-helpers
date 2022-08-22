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

    public function testComboKebabToSnakeCase(): void
    {
        $string = "the-quick-brown-fox-jumps-over-the-lazy-dog";

        $camelCase = StringHelper::kebabToCamelCase($string);
        $snakeCase = StringHelper::camelToSnakeCase($camelCase);

        $this->assertEquals("the_quick_brown_fox_jumps_over_the_lazy_dog", $snakeCase);
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

    public function testIsNonEmptyString(): void
    {
        // Positive
        $this->assertTrue(StringHelper::isNonEmptyString("hello world"));

        // Negative
        $this->assertFalse(StringHelper::isNonEmptyString(''));
        $this->assertFalse(StringHelper::isNonEmptyString(null));
        $this->assertFalse(StringHelper::isNonEmptyString(42));
        $this->assertFalse(StringHelper::isNonEmptyString(3.1415926));
        $this->assertFalse(StringHelper::isNonEmptyString(["hello world"]));
    }

    public function testKebabToCamelCase(): void
    {
        $result = StringHelper::kebabToCamelCase("hello-world");
        $this->assertEquals("helloWorld", $result);

        $result = StringHelper::kebabToCamelCase("the-quick-brown-fox-jumps-over-the-lazy-dog");
        $this->assertEquals("theQuickBrownFoxJumpsOverTheLazyDog", $result);
    }
}
