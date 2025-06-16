<?php

declare(strict_types=1);

namespace App\Tests\Helper;

use App\Common\Application\Dto\ContactDetailsData;

final class ContactDetailsDataFactory
{
    public static function valid(): ContactDetailsData
    {
        return new ContactDetailsData(
            firstname: 'John',
            surname: 'Doe',
            phone: '1234567890'
        );
    }

    public static function withCustomData(string $firstname, string $surname, string $phone): ContactDetailsData
    {
        return new ContactDetailsData(
            firstname: $firstname,
            surname: $surname,
            phone: $phone
        );
    }

    public static function empty(): ContactDetailsData
    {
        return new ContactDetailsData(
            firstname: '',
            surname: '',
            phone: ''
        );
    }
}
