<?php

declare(strict_types=1);

namespace App\Attribute\Infrastructure\Repository;

use App\Attribute\Domain\Repository\AttributeRepositoryInterface;
use App\Common\Domain\Entity\Attribute;
use App\Common\Domain\Entity\AttributeValue;
use App\Common\Infrastructure\Repository\Abstract\AbstractCriteriaRepository;
use App\Common\Infrastructure\Traits\PositionRepositoryTrait;

class AttributeDoctrineRepository extends AbstractCriteriaRepository implements AttributeRepositoryInterface
{
    use PositionRepositoryTrait;

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
