<?php

declare(strict_types=1);

namespace App\Brand\Infrastructure\Repository;

use App\Brand\Domain\Repository\BrandRepositoryInterface;
use App\Common\Domain\Entity\Brand;
use App\Shared\Infrastructure\Repository\AbstractCriteriaRepository;

class BrandDoctrineRepository extends AbstractCriteriaRepository implements BrandRepositoryInterface
{

    protected function getEntityClass(): string
    {
        return Brand::class;
    }

    protected function getAlias(): string
    {
        return 'brand';
    }
}
