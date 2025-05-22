<?php

declare(strict_types=1);

namespace App\Admin\Infrastructure\Repository;

use App\Admin\Domain\Entity\Promotion;
use App\Admin\Domain\Repository\PromotionRepositoryInterface;
use App\Shared\Infrastructure\Repository\AbstractCriteriaRepository;

class PromotionDoctrineRepository extends AbstractCriteriaRepository implements PromotionRepositoryInterface
{

    protected function getAlias(): string
    {
        return 'p';
    }

    protected function getEntityClass(): string
    {
        return Promotion::class;
    }
}
