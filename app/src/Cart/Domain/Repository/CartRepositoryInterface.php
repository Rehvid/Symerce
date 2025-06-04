<?php

declare(strict_types=1);

namespace App\Cart\Domain\Repository;

use App\Admin\Domain\Repository\QueryRepositoryInterface;
use App\Admin\Domain\Repository\ReadWriteRepositoryInterface;
use App\Common\Domain\Entity\Cart;
use App\Shared\Domain\Repository\CriteriaRepositoryInterface;

interface CartRepositoryInterface extends QueryRepositoryInterface, ReadWriteRepositoryInterface, CriteriaRepositoryInterface
{
    public function findByToken(?string $token): ?Cart;
}
