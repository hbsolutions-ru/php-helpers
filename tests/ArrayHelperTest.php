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

    public function testFlattenEmptyArray(): void
    {
        $dataSet = [];

        $result = ArrayHelper::flatten($dataSet);

        $this->assertEmpty($result);
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

    public function testMapKeys(): void
    {
        $array = [
            'first' => 'John',
            'last' => 'Doe',
            'age' => 25,
            'address' => 'Moscow',
        ];
        $map = [
            'first' => 'firstName',
            'last' => 'lastName',
            'address' => 'location',
        ];

        $result = ArrayHelper::mapKeys($array, $map);

        $this->assertCount(count($array), $result);

        $this->assertArrayHasKey('firstName', $result);
        $this->assertArrayHasKey('lastName', $result);
        $this->assertArrayHasKey('location', $result);

        $this->assertEquals($array['first'], $result['firstName']);
        $this->assertEquals($array['last'], $result['lastName']);
        $this->assertEquals($array['address'], $result['location']);
    }

    public function testRemoveAllItemsWithValue(): void
    {
        $array = ['one', 'two', 4, 2, null, 'two', 6, 'three', null];

        ArrayHelper::removeAllItemsWithValue($array, null);
        $this->assertCount(7, $array);

        ArrayHelper::removeAllItemsWithValue($array, 'two');
        $this->assertCount(5, $array);

        ArrayHelper::removeAllItemsWithValue($array, 6);
        $this->assertCount(4, $array);
    }
}
