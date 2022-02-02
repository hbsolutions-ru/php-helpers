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

    public function testObjectsToArray(): void
    {
        $object1 = new \stdClass();
        $object1->firstName = 'John';
        $object1->lastName = 'Doe';
        $object1->middleName = null;
        $object1->age = 25;

        $object2 = new \stdClass();
        $object2->firstName = 'Jane';
        $object2->lastName = 'Doe';
        $object2->middleName = null;
        $object2->age = 23;

        $object3 = new \stdClass();
        $object3->firstName = 'John';
        $object3->lastName = 'Smith';
        $object3->middleName = 'Jack';
        $object3->age = 30;

        $array = ObjectHelper::objectsToArray([$object1, $object2, $object3]);

        $this->assertCount(3, $array);

        $this->assertIsArray($array[0]);
        $this->assertCount(4, $array[0]);

        $this->assertIsArray($array[1]);
        $this->assertCount(4, $array[1]);

        $this->assertIsArray($array[2]);
        $this->assertCount(4, $array[2]);
    }
}
