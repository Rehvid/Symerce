<?php

namespace App\Mapper;

use App\DTO\Request\Attribute\SaveAttributeRequestDTO;
use App\Entity\Attribute;
use App\Interfaces\PersistableInterface;
use App\Mapper\Interface\RequestToEntityMapperInterface;

class AttributeMapper implements RequestToEntityMapperInterface
{

    public function toNewEntity(PersistableInterface $persistable): object
    {
        return $this->fillEntity(new Attribute(), $persistable);
    }

    public function toExistingEntity(PersistableInterface $persistable, object $entity): object
    {
        return $this->fillEntity($entity, $persistable);
    }

    private function fillEntity(Attribute $attribute, SaveAttributeRequestDTO $saveAttributeRequestDTO): Attribute
    {
        $attribute->setName($saveAttributeRequestDTO->name);
        return $attribute;
    }
}
