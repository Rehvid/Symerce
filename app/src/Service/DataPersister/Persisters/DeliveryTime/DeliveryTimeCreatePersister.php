<?php

namespace App\Service\DataPersister\Persisters\DeliveryTime;

use App\DTO\Request\DeliveryTime\SaveDeliveryTimeRequestDTO;
use App\Entity\DeliveryTime;
use App\Enums\DeliveryType;
use App\Interfaces\PersistableInterface;
use App\Service\DataPersister\Base\CreatePersister;

class DeliveryTimeCreatePersister extends CreatePersister
{

    protected function createEntity(PersistableInterface|SaveDeliveryTimeRequestDTO $persistable): object
    {
        $deliveryTime = new DeliveryTime();
        $deliveryTime->setType(DeliveryType::from($persistable->type));
        $deliveryTime->setLabel($persistable->label);
        $deliveryTime->setMaxDays((int) $persistable->maxDays);
        $deliveryTime->setMinDays((int) $persistable->minDays);

        return $deliveryTime;
    }

    public function getSupportedClasses(): array
    {
        return [SaveDeliveryTimeRequestDTO::class];
    }
}
