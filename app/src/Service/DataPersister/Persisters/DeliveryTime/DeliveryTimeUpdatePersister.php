<?php

namespace App\Service\DataPersister\Persisters\DeliveryTime;

use App\DTO\Request\DeliveryTime\SaveDeliveryTimeRequestDTO;
use App\Entity\DeliveryTime;
use App\Enums\DeliveryType;
use App\Interfaces\PersistableInterface;
use App\Service\DataPersister\Base\UpdatePersister;

class DeliveryTimeUpdatePersister extends UpdatePersister
{

    protected function updateEntity(PersistableInterface|SaveDeliveryTimeRequestDTO $persistable, object $entity): object
    {
        $entity->setType(DeliveryType::from($persistable->type));
        $entity->setLabel($persistable->label);
        $entity->setMaxDays((int) $persistable->maxDays);
        $entity->setMinDays((int) $persistable->minDays);

        return $entity;
    }

    public function getSupportedClasses(): array
    {
        return [DeliveryTime::class, SaveDeliveryTimeRequestDTO::class];
    }
}
