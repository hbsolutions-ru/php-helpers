<?php declare(strict_types=1);

namespace Tests;

use PHPUnit\Framework\TestCase;
use HBS\Helpers\ObjectHelper;
use Tests\ObjectHelperData\{
    Customer,
    Order,
    User,
};

final class ObjectHelperTest extends TestCase
{
    public function testCastWithPublicProperties(): void
    {
        $user = new User();
        $user->id = 1;
        $user->firstName = 'John';
        $user->lastName = 'Doe';
        $user->middleName = null;
        $user->age = 25;

        /** @var Customer $customer */
        $customer = ObjectHelper::castWithPublicProperties($user, Customer::class);

        $this->assertEquals(Customer::class, get_class($customer));

        $this->assertEquals($user->id, $customer->id);
        $this->assertEquals($user->firstName, $customer->firstName);
        $this->assertEquals($user->lastName, $customer->lastName);
        $this->assertEquals($user->middleName, $customer->middleName);
        $this->assertEquals($user->age, $customer->age);
    }

    public function testExtractIds(): void
    {
        $order1 = new Order();
        $order1->id = 1;
        $order1->customerId = 35;
        $order1->productName = 'iPhone 12';
        $order1->amount = 2;

        $order2 = new Order();
        $order2->id = 2;
        $order2->customerId = 46;
        $order2->productName = 'MacBook Pro';
        $order2->amount = 2;

        $orders = [
            $order1,
            $order2,
        ];

        $customerIds = ObjectHelper::extractIds($orders, 'customerId');

        $this->assertCount(2, $customerIds);

        $this->assertEquals($order1->customerId, $customerIds[0]);
        $this->assertEquals($order2->customerId, $customerIds[1]);
    }

    public function testHydrateFromArray(): void
    {
        $data = [
            'id' => 1,
            'firstName' => 'John',
            'lastName' => 'Doe',
            'middleName' => null,
            'age' => 25,
        ];

        /** @var User $user */
        $user = ObjectHelper::hydrateFromArray($data, User::class);

        $this->assertEquals(User::class, get_class($user));

        $this->assertEquals($data['id'], $user->id);
        $this->assertEquals($data['firstName'], $user->firstName);
        $this->assertEquals($data['lastName'], $user->lastName);
        $this->assertEquals($data['middleName'], $user->middleName);
        $this->assertEquals($data['age'], $user->age);
    }

    public function testObjectsToArray(): void
    {
        $user1 = new User();
        $user1->id = 1;
        $user1->firstName = 'John';
        $user1->lastName = 'Doe';
        $user1->middleName = null;
        $user1->age = 25;

        $user2 = new User();
        $user2->id = 2;
        $user2->firstName = 'Jane';
        $user2->lastName = 'Doe';
        $user2->middleName = null;
        $user2->age = 23;

        $user3 = new User();
        $user3->id = 3;
        $user3->firstName = 'John';
        $user3->lastName = 'Smith';
        $user3->middleName = 'Jack';
        $user3->age = 30;

        $array = ObjectHelper::objectsToArray([$user1, $user2, $user3]);

        $this->assertCount(3, $array);

        $this->assertIsArray($array[0]);
        $this->assertCount(5, $array[0]);

        $this->assertIsArray($array[1]);
        $this->assertCount(5, $array[1]);

        $this->assertIsArray($array[2]);
        $this->assertCount(5, $array[2]);
    }

    public function testToArray(): void
    {
        $user = new User();
        $user->id = 1;
        $user->firstName = 'John';
        $user->lastName = 'Doe';
        $user->middleName = null;
        $user->age = 25;

        $array = ObjectHelper::toArray($user);

        $this->assertCount(5, $array);

        $this->assertArrayHasKey('id', $array);
        $this->assertArrayHasKey('firstName', $array);
        $this->assertArrayHasKey('lastName', $array);
        $this->assertArrayHasKey('middleName', $array);
        $this->assertArrayHasKey('age', $array);

        $this->assertEquals($user->id, $array['id']);
        $this->assertEquals($user->firstName, $array['firstName']);
        $this->assertEquals($user->lastName, $array['lastName']);
        $this->assertEquals($user->middleName, $array['middleName']);
        $this->assertEquals($user->age, $array['age']);
    }
}
