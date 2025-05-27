<?php

declare(strict_types=1);

namespace App\Shared\Application\Hydrator;

use App\Shared\Application\DTO\Request\Address\SaveAddressRequest;
use App\Shop\Domain\Entity\Embeddables\Address;

final readonly class AddressHydrator
{
    public function hydrate(SaveAddressRequest $request, ?Address $address = null): Address
    {
        $address = $address ?? new Address();
        $address->setCountry($request->country);
        $address->setCity($request->city);
        $address->setStreet($request->street);
        $address->setPostalCode($request->postalCode);

        return $address;
    }
}
