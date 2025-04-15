<?php

declare(strict_types=1);

namespace App\Service\DataPersister\Persisters\Attribute;

use App\DTO\Request\Attribute\SaveAttributeRequestDTO;
use App\Entity\Attribute;
use App\Interfaces\PersistableInterface;
use App\Service\DataPersister\Base\CreatePersister;

class AttributeCreatePersister extends CreatePersister
{

    /**
     * @param SaveAttributeRequestDTO $persistable;
     */
    protected function createEntity(PersistableInterface $persistable): object
    {
        $attribute = new Attribute();
        $attribute->setName($persistable->name);

        return $attribute;
    }

    public function getSupportedClasses(): array
    {
        return [SaveAttributeRequestDTO::class];
    }
}
