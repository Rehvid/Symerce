<?php

namespace App\Service\DataPersister\Persisters\Attribute;

use App\DTO\Request\Attribute\SaveAttributeRequestDTO;
use App\Entity\Attribute;
use App\Interfaces\PersistableInterface;
use App\Service\DataPersister\Base\UpdatePersister;

class AttributeUpdatePersister extends UpdatePersister
{

    /**
     * @param SaveAttributeRequestDTO $persistable
     * @param Attribute $entity
     * @return Attribute
     *
     */
    protected function updateEntity(PersistableInterface $persistable, object $entity): object
    {
        $entity->setName($persistable->name);
        return $entity;
    }

    public function getSupportedClasses(): array
    {
        return [Attribute::class, SaveAttributeRequestDTO::class];
    }
}
