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

        $this->assertArrayNotHasKey('middleName', $result);
        $this->assertArrayNotHasKey('address', $result);
    }

    public function testFlatten(): void
    {
        $dataSet = [
            [1, 'Field1', 'Value1'],
            [2, 'Field2', 'Value2'],
            [3, 'Field3', 'Value3'],
        ];
        $expected = [1, 'Field1', 'Value1', 2, 'Field2', 'Value2', 3, 'Field3', 'Value3'];

        $result = ArrayHelper::flatten($dataSet);

        $this->assertCount(count($expected), $result);

        foreach ($result as $index => $value) {
            $this->assertEquals($expected[$index], $value);
        }
    }

    public function testKeysFromColumn(): void
    {
        $dataSet = [
            ['id' => 1, 'entityId' => 65, 'name' => 'first'],
            ['id' => 2, 'entityId' => 32, 'name' => 'second'],
            ['id' => 3, 'entityId' => 98, 'name' => 'third'],
        ];

        $result = ArrayHelper::keysFromColumn($dataSet, 'entityId');

        $this->assertCount(3, $result);

        foreach ($result as $key => $value) {
            $this->assertEquals($key, $value['entityId']);
        }
    }
}
