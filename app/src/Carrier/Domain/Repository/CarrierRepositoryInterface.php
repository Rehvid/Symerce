<?php

declare(strict_types=1);

namespace App\Carrier\Domain\Repository;

use App\Common\Domain\Entity\Carrier;
use App\Common\Domain\Repository\CriteriaRepositoryInterface;
use App\Common\Domain\Repository\QueryRepositoryInterface;
use App\Common\Domain\Repository\ReadWriteRepositoryInterface;

/**
 * @extends QueryRepositoryInterface<Carrier>
 */
interface CarrierRepositoryInterface extends QueryRepositoryInterface, ReadWriteRepositoryInterface, CriteriaRepositoryInterface
{

}
