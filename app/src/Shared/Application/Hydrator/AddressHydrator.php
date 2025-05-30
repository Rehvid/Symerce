<?php

declare(strict_types=1);

namespace App\Shared\Application\Hydrator;

use App\Shared\Application\DTO\AddressData;
use App\Shared\Application\Factory\ValidationExceptionFactory;
use App\Shop\Domain\Entity\Embeddables\Address;

final readonly class AddressHydrator
{
    public function __construct(
        private ValidationExceptionFactory $validationExceptionFactory,
    ) {}

    public function hydrate(AddressData $data, ?Address $address = null): Address
    {
        $address = $address ?? new Address();
        if (null === $data->country) {
            $this->validationExceptionFactory->createNotFound('country');
        }
        $address->setCountry($data->country);
        $address->setCity($data->city);
        $address->setStreet($data->street);
        $address->setPostalCode($data->postalCode);

        return $address;
    }
}
