<?php

declare(strict_types=1);

namespace App\Admin\Domain\Repository;

use App\Entity\Cart;

interface CartRepositoryInterface extends QueryRepositoryInterface, ReadWriteRepositoryInterface
{
    public function findByCartToken(?string $token): ?Cart;
}
