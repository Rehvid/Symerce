<?php

declare(strict_types=1);

namespace App\Tests\Helper;

use App\Common\Domain\Entity\ContactDetails;
use App\Common\Domain\Entity\Customer;
use App\Customer\Domain\Enums\CustomerRole;

final class CustomerFactory
{
    public static function valid(): Customer
    {
        $customer = new Customer();
        $customer->setRoles([CustomerRole::CUSTOMER->value]);
        $customer->setEmail('john@dee.com');
        $customer->setContactDetails(new ContactDetails());

        return $customer;
    }
}
