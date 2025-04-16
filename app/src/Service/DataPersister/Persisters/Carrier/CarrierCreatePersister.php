<?php

namespace App\Service\DataPersister\Persisters\Carrier;

use App\DTO\Request\Carrier\SaveCarrierRequestDTO;
use App\Interfaces\PersistableInterface;
use App\Mapper\CarrierMapper;
use App\Service\DataPersister\Base\CreatePersister;
use Doctrine\ORM\EntityManagerInterface;

class CarrierCreatePersister extends CreatePersister
{
    public function __construct(
        EntityManagerInterface $entityManager,
        private readonly CarrierMapper $mapper
    )
    {
        parent::__construct($entityManager);
    }

    protected function createEntity(SaveCarrierRequestDTO|PersistableInterface $persistable): object
    {
        return $this->mapper->toNewEntity($persistable);
    }

    public function getSupportedClasses(): array
    {
        return [SaveCarrierRequestDTO::class];
    }
}
