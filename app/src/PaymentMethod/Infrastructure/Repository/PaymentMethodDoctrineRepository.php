<?php

declare(strict_types=1);

namespace App\PaymentMethod\Infrastructure\Repository;

use App\Admin\Infrastructure\Traits\PositionRepositoryTrait;
use App\Common\Domain\Entity\PaymentMethod;
use App\PaymentMethod\Domain\Repository\PaymentMethodRepositoryInterface;
use App\Shared\Infrastructure\Repository\AbstractCriteriaRepository;

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
