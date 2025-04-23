<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Attribute;
use App\Entity\AttributeValue;
use App\Repository\Base\PaginationRepository;

class AttributeRepository extends PaginationRepository
{
    protected function getEntityClass(): string
    {
        return Attribute::class;
    }

    protected function getAlias(): string
    {
        return 'attribute';
    }

    public function getAttributeValuesByAttributes(array $attributes): array
    {
        $qb = $this->createQueryBuilder($this->getAlias());
        $qb->select('av')
            ->from(AttributeValue::class, 'av');

        $orX = $qb->expr()->orX();

        foreach ($attributes as $attributeId => $valueIds) {
            $paramAttr = 'attr_' . $attributeId;
            $paramVals = 'vals_' . $attributeId;

            $orX->add(
                $qb->expr()->andX(
                    $qb->expr()->eq('av.attribute', ":$paramAttr"),
                    $qb->expr()->in("av.id", ":$paramVals")
                )
            );

            $qb->setParameter($paramAttr, $attributeId);
            $qb->setParameter($paramVals, $valueIds);
        }

        $qb->where($orX);

        return $qb->getQuery()->getResult();
    }
}
