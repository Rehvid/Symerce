<?php

declare(strict_types=1);

namespace App\PaymentMethod\Infrastructure\Repository;

use App\Admin\Domain\Entity\PaymentMethod;
use App\Admin\Infrastructure\Traits\ReorderRepositoryTrait;
use App\PaymentMethod\Domain\Repository\PaymentMethodRepositoryInterface;
use App\Shared\Infrastructure\Repository\AbstractCriteriaRepository;

final class PaymentMethodDoctrineRepository extends AbstractCriteriaRepository implements PaymentMethodRepositoryInterface
{
    use ReorderRepositoryTrait;


    protected function getEntityClass(): string
    {
        return PaymentMethod::class;
    }

    protected function getAlias(): string
    {
        return 'pm';
    }

}
