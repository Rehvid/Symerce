<?php

declare(strict_types=1);

namespace App\Shop\Application\Hydrator;

use App\Common\Application\Dto\Request\Address\SaveAddressDeliveryRequest;
use App\Common\Domain\Entity\DeliveryAddress;

final readonly class DeliveryAddressHydrator
{
    public function hydrate(SaveAddressDeliveryRequest $request, DeliveryAddress $deliveryAddress): DeliveryAddress
    {
        $deliveryAddress->setDeliveryInstructions($request->deliveryInstructions);

        return $deliveryAddress;
    }
}
