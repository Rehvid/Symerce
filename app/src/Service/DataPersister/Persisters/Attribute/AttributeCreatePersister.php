<?php

declare(strict_types=1);

namespace App\Service\DataPersister\Persisters\Attribute;

use App\DTO\Request\Attribute\SaveAttributeRequestDTO;
use App\Entity\Attribute;
use App\Interfaces\PersistableInterface;
use App\Mapper\AttributeMapper;
use App\Service\DataPersister\Base\CreatePersister;
use Doctrine\ORM\EntityManagerInterface;

class AttributeCreatePersister extends CreatePersister
{
    public function __construct(
        EntityManagerInterface $entityManager,
        private readonly AttributeMapper $mapper,
    )
    {
        parent::__construct($entityManager);
    }

    /**
     * @param SaveAttributeRequestDTO $persistable;
     */
    protected function createEntity(PersistableInterface $persistable): object
    {
        return $this->mapper->toNewEntity($persistable);
    }

    public function getSupportedClasses(): array
    {
        return [SaveAttributeRequestDTO::class];
    }
}
