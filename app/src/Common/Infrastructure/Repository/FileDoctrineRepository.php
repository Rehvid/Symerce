<?php

declare(strict_types=1);

namespace App\Common\Infrastructure\Repository;

use App\Common\Domain\Entity\File;
use App\Common\Domain\Repository\FileRepositoryInterface;
use App\Common\Infrastructure\Repository\Abstract\DoctrineRepository;

/**
 * @extends DoctrineRepository<File>
 */
final class FileDoctrineRepository extends DoctrineRepository implements FileRepositoryInterface
{
    protected function getEntityClass(): string
    {
        return  File::class;
    }

    protected function getAlias(): string
    {
        return 'file';
    }
}
