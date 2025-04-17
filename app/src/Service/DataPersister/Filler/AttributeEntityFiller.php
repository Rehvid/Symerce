<?php

declare(strict_types=1);

namespace App\Service\DataPersister\Filler;

use App\DTO\Request\Attribute\SaveAttributeRequestDTO;
use App\DTO\Request\PersistableInterface;
use App\Entity\Attribute;
use App\Repository\AttributeRepository;
use App\Service\DataPersister\Filler\Base\BaseEntityFiller;

/**
 * @extends BaseEntityFiller<SaveAttributeRequestDTO>
 */
final class AttributeEntityFiller extends BaseEntityFiller
{
    public function __construct(private readonly AttributeRepository $attributeRepository)
    {
    }

    public function toNewEntity(PersistableInterface $persistable): object
    {
        $attribute = new Attribute();
        $attribute->setOrder($this->attributeRepository->count());

        return $this->fillEntity($persistable, $attribute);
    }

    /**
     * @param Attribute $entity
     */
    public function toExistingEntity(PersistableInterface $persistable, object $entity): Attribute
    {
        return $this->fillEntity($persistable, $entity);
    }

    public static function supports(): string
    {
        return SaveAttributeRequestDTO::class;
    }

    /**
     * @param Attribute $entity
     */
    protected function fillEntity(PersistableInterface|SaveAttributeRequestDTO $persistable, object $entity): Attribute
    {
        $entity->setName($persistable->name);

        return $entity;
    }
}
