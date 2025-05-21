<?php

declare(strict_types=1);

namespace App\Admin\Infrastructure\Repository;

use App\Admin\Domain\Entity\Attribute;
use App\Admin\Domain\Entity\AttributeValue;
use App\Admin\Domain\Repository\AttributeRepositoryInterface;
use App\Admin\Infrastructure\Traits\ReorderRepositoryTrait;
use App\Shared\Infrastructure\Repository\AbstractCriteriaRepository;

class AttributeDoctrineRepository extends AbstractCriteriaRepository implements AttributeRepositoryInterface
{
    use ReorderRepositoryTrait;

    protected function getEntityClass(): string
    {
        return Attribute::class;
    }

    protected function getAlias(): string
    {
        return 'attribute';
    }

    /**
     * @param array<string, mixed> $attributes
     *
     * @return array<int, mixed>
     */
    public function getAttributeValuesByAttributes(array $attributes): array
    {
        $qb = $this->createQueryBuilder($this->getAlias());
        $qb->select('av')
            ->from(AttributeValue::class, 'av');

        $orX = $qb->expr()->orX();

        foreach ($attributes as $attributeId => $valueIds) {
            $paramAttr = 'attr_'.$attributeId;
            $paramVals = 'vals_'.$attributeId;

            $orX->add(
                $qb->expr()->andX(
                    $qb->expr()->eq('av.attribute', ":$paramAttr"),
                    $qb->expr()->in('av.id', ":$paramVals")
                )
            );

            $qb->setParameter($paramAttr, $attributeId);
            $qb->setParameter($paramVals, $valueIds);
        }

        $qb->where($orX);

        return $qb->getQuery()->getResult();
    }
}
