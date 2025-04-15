<?php

declare(strict_types=1);

namespace App\Service\DataPersister\Persisters\AttributeValue;

use App\DTO\Request\AttributeValue\SaveAttributeValueRequestDTO;
use App\Entity\AttributeValue;
use App\Interfaces\PersistableInterface;
use App\Service\DataPersister\Base\UpdatePersister;

class AttributeValueUpdatePersister extends UpdatePersister
{

    protected function updateEntity(PersistableInterface $persistable, object $entity): object
    {
        $entity->setValue($persistable->value);
        return $entity;
    }

    public function getSupportedClasses(): array
    {
        return [AttributeValue::class, SaveAttributeValueRequestDTO::class];
    }
}
