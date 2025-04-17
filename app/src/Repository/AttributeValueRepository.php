<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\AttributeValue;
use App\Repository\Base\PaginationRepository;

class AttributeValueRepository extends PaginationRepository
{
    protected function getEntityClass(): string
    {
        return AttributeValue::class;
    }

    protected function getAlias(): string
    {
        return 'attribute_value';
    }
}
