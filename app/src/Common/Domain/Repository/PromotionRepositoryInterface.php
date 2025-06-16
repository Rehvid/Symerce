<?php

declare(strict_types=1);

namespace App\Common\Domain\Repository;

use App\Common\Domain\Entity\Promotion;

/**
 * @extends QueryRepositoryInterface<Promotion>
 */
interface PromotionRepositoryInterface extends ReadWriteRepositoryInterface, QueryRepositoryInterface, CriteriaRepositoryInterface
{
}
