<?php declare(strict_types=1);

namespace Tests;

use PHPUnit\Framework\TestCase;
use HBS\Helpers\ArrayHelper;

final class ArrayHelperTest extends TestCase
{
    public function testFilterNulls(): void
    {
        $simpleArray = [0, '', [], null, false, true, 0.5];
        $result = ArrayHelper::filterNulls($simpleArray);

        $this->assertCount(6, $result);
        $this->assertEquals([0, '', [], 4 => false, 5 => true, 6 => 0.5], $result);

        $assocArray = [
            'firstName' => 'John',
            'lastName' => 'Doe',
            'middleName' => null,
            'age' => 25,
            'address' => null,
        ];
        $result = ArrayHelper::filterNulls($assocArray);

        $this->assertCount(3, $result);

        $this->assertArrayHasKey('firstName', $result);
        $this->assertArrayHasKey('lastName', $result);
        $this->assertArrayHasKey('age', $result);
    }
}
