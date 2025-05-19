<?php

declare (strict_types = 1);

namespace App\Admin\Application\Hydrator;

use App\Admin\Application\DTO\Request\DeliveryTime\SaveDeliveryTimeRequest;
use App\Admin\Domain\Enums\DeliveryType;
use App\Entity\DeliveryTime;

final readonly class DeliveryTimeHydrator
{
    public function __construct(

    ) {
    }

    public function hydrate(SaveDeliveryTimeRequest $request, DeliveryTime $deliveryTime): DeliveryTime
    {
       $deliveryTime->setActive($request->isActive);
       $deliveryTime->setType(DeliveryType::from($request->type));
       $deliveryTime->setMinDays((int) $request->minDays);
       $deliveryTime->setMaxDays((int) $request->maxDays);
       $deliveryTime->setLabel($request->label);

        return $deliveryTime;
    }
}
