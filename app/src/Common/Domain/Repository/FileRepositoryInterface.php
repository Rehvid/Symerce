<?php

declare(strict_types=1);

namespace App\Common\Domain\Repository;

use App\Common\Domain\Entity\File;

/**
 * @extends QueryRepositoryInterface<File>
 */
interface FileRepositoryInterface extends ReadWriteRepositoryInterface, QueryRepositoryInterface
{
}
