<?php

declare(strict_types=1);

namespace App\PaymentMethod\Infrastructure\Repository;

use App\Common\Domain\Entity\PaymentMethod;
use App\Common\Infrastructure\Repository\Abstract\AbstractCriteriaRepository;
use App\Common\Infrastructure\Traits\PositionRepositoryTrait;
use App\PaymentMethod\Domain\Repository\PaymentMethodRepositoryInterface;

final class PaymentMethodDoctrineRepository extends AbstractCriteriaRepository implements PaymentMethodRepositoryInterface
{
    use PositionRepositoryTrait;


    protected function getEntityClass(): string
    {
        return PaymentMethod::class;
    }

    protected function getAlias(): string
    {
        return 'pm';
    }

}
