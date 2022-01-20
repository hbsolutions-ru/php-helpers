<?php declare(strict_types=1);

namespace Tests;

use PHPUnit\Framework\TestCase;
use HBS\Helpers\ObjectHelper;

final class ObjectHelperTest extends TestCase
{
    public function testToArray(): void
    {
        $object = new \stdClass();
        $object->firstName = 'John';
        $object->lastName = 'Doe';
        $object->middleName = null;
        $object->age = 25;

        $array = ObjectHelper::toArray($object);

        $this->assertCount(4, $array);

        $this->assertArrayHasKey('firstName', $array);
        $this->assertArrayHasKey('lastName', $array);
        $this->assertArrayHasKey('middleName', $array);
        $this->assertArrayHasKey('age', $array);

        $this->assertEquals($object->firstName, $array['firstName']);
        $this->assertEquals($object->lastName, $array['lastName']);
        $this->assertEquals($object->middleName, $array['middleName']);
        $this->assertEquals($object->age, $array['age']);
    }
}
