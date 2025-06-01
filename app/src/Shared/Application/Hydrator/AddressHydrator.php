<?php

declare(strict_types=1);

namespace App\Shared\Application\Hydrator;

use App\Common\Domain\Entity\Country;
use App\Common\Domain\Entity\Embeddables\Address;
use App\Common\Domain\Exception\EntityNotFoundException;
use App\Shared\Application\DTO\AddressData;

final readonly class AddressHydrator
{
    public function hydrate(AddressData $data, ?Address $address = null): Address
    {
        $address = $address ?? new Address();
        if (null === $data->country) {
            throw EntityNotFoundException::for(Country::class, $data->country?->getId());
        }

        $address->setCountry($data->country);
        $address->setCity($data->city);
        $address->setStreet($data->street);
        $address->setPostalCode($data->postalCode);

        return $address;
    }
}
