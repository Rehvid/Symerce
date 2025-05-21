<?php

declare(strict_types=1);

namespace App\Admin\Infrastructure\Repository;

use App\Admin\Domain\Entity\PaymentMethod;
use App\Admin\Domain\Repository\PaymentMethodRepositoryInterface;
use App\Admin\Infrastructure\Traits\ReorderRepositoryTrait;
use App\Shared\Infrastructure\Repository\AbstractCriteriaRepository;

class PaymentMethodDoctrineRepository extends AbstractCriteriaRepository implements PaymentMethodRepositoryInterface
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
