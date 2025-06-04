<?php

declare(strict_types=1);

namespace App\Cart\Domain\Repository;

use App\Common\Domain\Entity\Cart;
use App\Common\Domain\Repository\CriteriaRepositoryInterface;
use App\Common\Domain\Repository\QueryRepositoryInterface;
use App\Common\Domain\Repository\ReadWriteRepositoryInterface;

interface CartRepositoryInterface extends QueryRepositoryInterface, ReadWriteRepositoryInterface, CriteriaRepositoryInterface
{
    public function findByToken(?string $token): ?Cart;
}
