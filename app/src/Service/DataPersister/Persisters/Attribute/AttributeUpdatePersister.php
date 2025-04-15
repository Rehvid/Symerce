<?php

namespace App\Service\DataPersister\Persisters\Attribute;

use App\DTO\Request\Attribute\SaveAttributeRequestDTO;
use App\Entity\Attribute;
use App\Interfaces\PersistableInterface;
use App\Mapper\AttributeMapper;
use App\Service\DataPersister\Base\UpdatePersister;
use Doctrine\ORM\EntityManagerInterface;

class AttributeUpdatePersister extends UpdatePersister
{

    public function __construct(
        EntityManagerInterface $entityManager,
        private readonly AttributeMapper $mapper
    )
    {
        parent::__construct($entityManager);
    }

    /**
     * @param SaveAttributeRequestDTO $persistable
     * @param Attribute $entity
     * @return Attribute
     *
     */
    protected function updateEntity(PersistableInterface $persistable, object $entity): object
    {
        return $this->mapper->toExistingEntity($persistable, $entity);
    }

    public function getSupportedClasses(): array
    {
        return [Attribute::class, SaveAttributeRequestDTO::class];
    }
}
