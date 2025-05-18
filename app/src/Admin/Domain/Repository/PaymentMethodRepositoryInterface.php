<?php

declare(strict_types=1);

namespace App\Admin\Domain\Repository;

interface PaymentMethodRepositoryInterface extends QueryRepositoryInterface, ReadWriteRepositoryInterface
{
    public function getMaxOrder(): int;
}
