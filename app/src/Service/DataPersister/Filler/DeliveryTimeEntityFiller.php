<?php

declare(strict_types=1);

namespace App\Service\DataPersister\Filler;

use App\DTO\Request\DeliveryTime\SaveDeliveryTimeRequestDTO;
use App\DTO\Request\PersistableInterface;
use App\Entity\DeliveryTime;
use App\Enums\DeliveryType;
use App\Repository\DeliveryTimeRepository;
use App\Service\DataPersister\Filler\Base\BaseEntityFiller;

/**
 * @extends BaseEntityFiller<SaveDeliveryTimeRequestDTO>
 */
final class DeliveryTimeEntityFiller extends BaseEntityFiller
{
    public function __construct(private readonly DeliveryTimeRepository $deliveryTimeRepository)
    {
    }

    public function toNewEntity(PersistableInterface $persistable): DeliveryTime
    {
        $deliveryTime = new DeliveryTime();
        $deliveryTime->setOrder($this->deliveryTimeRepository->count());

        return $this->fillEntity($persistable, new DeliveryTime());
    }

    /**
     * @param DeliveryTime $entity
     */
    public function toExistingEntity(PersistableInterface $persistable, object $entity): DeliveryTime
    {
        return $this->fillEntity($persistable, $entity);
    }

    public static function supports(): string
    {
        return SaveDeliveryTimeRequestDTO::class;
    }

    /**
     * @param DeliveryTime $entity
     */
    protected function fillEntity(
        PersistableInterface|SaveDeliveryTimeRequestDTO $persistable,
        object $entity
    ): DeliveryTime {
        $entity->setType(DeliveryType::from($persistable->type));
        $entity->setLabel($persistable->label);
        $entity->setMaxDays((int) $persistable->maxDays);
        $entity->setMinDays((int) $persistable->minDays);

        return $entity;
    }
}
