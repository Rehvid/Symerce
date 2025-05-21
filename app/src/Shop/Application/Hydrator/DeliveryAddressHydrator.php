<?php

declare(strict_types=1);

namespace App\Shop\Application\Hydrator;

use App\Shared\Domain\Entity\DeliveryAddress;
use App\Shop\Application\DTO\Request\Address\SaveAddressDeliveryRequest;

final readonly class DeliveryAddressHydrator
{
    public function hydrate(SaveAddressDeliveryRequest $request, DeliveryAddress $deliveryAddress): DeliveryAddress
    {
        $deliveryAddress->setDeliveryInstructions($request->deliveryInstructions);

        return $deliveryAddress;
    }
}
