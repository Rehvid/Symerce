<?php

declare(strict_types=1);

namespace App\Admin\Domain\Repository;

interface DeliveryTimeRepositoryInterface extends ReadWriteRepositoryInterface, QueryRepositoryInterface
{
    public function getMaxOrder(): int;
}
