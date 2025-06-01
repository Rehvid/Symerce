<?php

declare(strict_types=1);

namespace App\Shop\Application\Hydrator;

use App\Common\Domain\Entity\Embeddables\Address;
use App\Shared\Application\DTO\Request\Address\SaveAddressRequest;

final readonly class AddressHydrator
{
    public function hydrate(SaveAddressRequest $request, Address $address): Address
    {
        $address->setCity($request->city);
        $address->setStreet($request->street);
        $address->setPostalCode($request->postalCode);
        $address->setCountry($request->country);

        return $address;
    }
}
