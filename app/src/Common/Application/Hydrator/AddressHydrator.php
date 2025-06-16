<?php

declare(strict_types=1);

namespace App\Common\Application\Hydrator;

use App\Common\Application\Dto\AddressData;
use App\Common\Domain\Entity\Address;
use App\Common\Domain\Entity\Country;
use App\Common\Domain\Exception\EntityNotFoundException;

final readonly class AddressHydrator
{
    public function hydrate(AddressData $data, Address $address): Address
    {
        if (null === $data->country) {
            throw EntityNotFoundException::for(Country::class, null);
        }

        $address->setCountry($data->country);
        $address->setCity($data->city);
        $address->setStreet($data->street);
        $address->setPostalCode($data->postalCode);

        return $address;
    }
}
