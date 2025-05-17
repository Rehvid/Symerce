<?php

declare(strict_types=1);

namespace App\Admin\Domain\Repository;

interface PaymentMethodRepositoryInterface extends PersistableRepositoryInterface
{
    public function getMaxOrder(): int;
}
