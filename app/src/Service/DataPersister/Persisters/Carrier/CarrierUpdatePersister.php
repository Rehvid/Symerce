<?php

namespace App\Service\DataPersister\Persisters\Carrier;

use App\DTO\Request\Carrier\SaveCarrierRequestDTO;
use App\Entity\Carrier;
use App\Interfaces\PersistableInterface;
use App\Mapper\CarrierMapper;
use App\Service\DataPersister\Base\UpdatePersister;
use Doctrine\ORM\EntityManagerInterface;

class CarrierUpdatePersister extends UpdatePersister
{
    public function __construct(
        EntityManagerInterface $entityManager,
        private readonly CarrierMapper $mapper
    )
    {
        parent::__construct($entityManager);
    }


    protected function updateEntity(PersistableInterface $persistable, object $entity): object
    {
        return $this->mapper->toExistingEntity($persistable, $entity);
    }

    public function getSupportedClasses(): array
    {
        return [Carrier::class, SaveCarrierRequestDTO::class];
    }
}
