<?php

declare(strict_types=1);

namespace App\Service\DataPersister\Filler\Admin;

use App\DTO\Admin\Request\AttributeValue\SaveAttributeValueRequestDTO;
use App\DTO\Admin\Request\PersistableInterface;
use App\Entity\Attribute;
use App\Entity\AttributeValue;
use App\Repository\AttributeRepository;
use App\Service\DataPersister\Filler\Base\BaseEntityFiller;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * @extends BaseEntityFiller<SaveAttributeValueRequestDTO>
 */
final class AttributeValueEntityFiller extends BaseEntityFiller
{
    public function __construct(
        private readonly AttributeRepository $attributeRepository,
    ) {
    }

    public function toNewEntity(PersistableInterface|SaveAttributeValueRequestDTO $persistable): AttributeValue
    {
        /** @var Attribute|null $attribute */
        $attribute = $this->attributeRepository->find($persistable->attributeId);

        if (null === $attribute) {
            throw new NotFoundHttpException('Attribute not found');
        }

        $entity = new AttributeValue();
        $entity->setAttribute($attribute);
        $entity->setOrder($this->attributeRepository->count());

        return $this->fillEntity($persistable, $entity);
    }

    /**
     * @param AttributeValue $entity
     */
    public function toExistingEntity(
        PersistableInterface|SaveAttributeValueRequestDTO $persistable,
        object $entity
    ): AttributeValue {
        return $this->fillEntity($persistable, $entity);
    }

    public static function supports(): string
    {
        return SaveAttributeValueRequestDTO::class;
    }

    /**
     * @param AttributeValue $entity
     */
    protected function fillEntity(
        PersistableInterface|SaveAttributeValueRequestDTO $persistable,
        object $entity
    ): AttributeValue {
        $entity->setValue($persistable->value);

        return $entity;
    }
}
