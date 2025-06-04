<?php

declare(strict_types=1);

namespace App\Common\Infrastructure\Repository;

use App\Common\Domain\Entity\Promotion;
use App\Common\Domain\Repository\PromotionRepositoryInterface;
use App\Common\Infrastructure\Repository\Abstract\AbstractCriteriaRepository;

final class PromotionDoctrineRepository extends AbstractCriteriaRepository implements PromotionRepositoryInterface
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
