<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\Attribute;
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
}
