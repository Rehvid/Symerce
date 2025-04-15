<?php

declare(strict_types=1);

namespace App\Service\DataPersister\Persisters\AttributeValue;

use App\DTO\Request\AttributeValue\SaveAttributeValueRequestDTO;
use App\Entity\Attribute;
use App\Entity\AttributeValue;
use App\Interfaces\PersistableInterface;
use App\Service\DataPersister\Base\CreatePersister;
use Doctrine\ORM\EntityNotFoundException;

class AttributeValueCreatePersister extends CreatePersister
{

    /** @param SaveAttributeValueRequestDTO $persistable */
    protected function createEntity(PersistableInterface $persistable): object
    {
        $attribute = $this->entityManager->getRepository(Attribute::class)->find($persistable->attributeId);
        if (null === $attribute) {
            throw new EntityNotFoundException();
        }

        $attributeValue = new AttributeValue();
        $attributeValue->setValue($persistable->value);
        $attributeValue->setAttribute($attribute);

        return $attributeValue;
    }


    public function getSupportedClasses(): array
    {
        return [SaveAttributeValueRequestDTO::class];
    }
}
