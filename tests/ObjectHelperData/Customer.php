<?php declare(strict_types=1);

namespace Tests\ObjectHelperData;

class Customer extends User
{
    /** @var string */
    public $deliveryAddress;

    /** @var int */
    public $postcode;

    /** @var int */
    public $totalNumberOfPurchases;
}
