<?php declare(strict_types=1);

namespace Tests;

use PHPUnit\Framework\TestCase;
use HBS\Helpers\ObjectHelper;
use Tests\ObjectHelperData\{
    Customer,
    User,
};

final class ObjectHelperTest extends TestCase
{
    public function testToArray(): void
    {
        $user = new User();
        $user->firstName = 'John';
        $user->lastName = 'Doe';
        $user->middleName = null;
        $user->age = 25;

        $array = ObjectHelper::toArray($user);

        $this->assertCount(4, $array);

        $this->assertArrayHasKey('firstName', $array);
        $this->assertArrayHasKey('lastName', $array);
        $this->assertArrayHasKey('middleName', $array);
        $this->assertArrayHasKey('age', $array);

        $this->assertEquals($user->firstName, $array['firstName']);
        $this->assertEquals($user->lastName, $array['lastName']);
        $this->assertEquals($user->middleName, $array['middleName']);
        $this->assertEquals($user->age, $array['age']);
    }

    public function testObjectsToArray(): void
    {
        $user1 = new User();
        $user1->firstName = 'John';
        $user1->lastName = 'Doe';
        $user1->middleName = null;
        $user1->age = 25;

        $user2 = new User();
        $user2->firstName = 'Jane';
        $user2->lastName = 'Doe';
        $user2->middleName = null;
        $user2->age = 23;

        $user3 = new User();
        $user3->firstName = 'John';
        $user3->lastName = 'Smith';
        $user3->middleName = 'Jack';
        $user3->age = 30;

        $array = ObjectHelper::objectsToArray([$user1, $user2, $user3]);

        $this->assertCount(3, $array);

        $this->assertIsArray($array[0]);
        $this->assertCount(4, $array[0]);

        $this->assertIsArray($array[1]);
        $this->assertCount(4, $array[1]);

        $this->assertIsArray($array[2]);
        $this->assertCount(4, $array[2]);
    }

    public function testCastWithPublicProperties(): void
    {
        $user = new User();
        $user->firstName = 'John';
        $user->lastName = 'Doe';
        $user->middleName = null;
        $user->age = 25;

        /** @var Customer $customer */
        $customer = ObjectHelper::castWithPublicProperties($user, Customer::class);

        $this->assertEquals(Customer::class, get_class($customer));

        $this->assertEquals($user->firstName, $customer->firstName);
        $this->assertEquals($user->lastName, $customer->lastName);
        $this->assertEquals($user->middleName, $customer->middleName);
        $this->assertEquals($user->age, $customer->age);
    }
}
