<?php

declare(strict_types=1);

namespace App\Admin\Infrastructure\Repository;

use App\Admin\Domain\Repository\FileRepositoryInterface;
use App\Common\Domain\Entity\File;
use App\Shared\Infrastructure\Repository\DoctrineRepository;

class FileDoctrineRepository extends DoctrineRepository implements FileRepositoryInterface
{

    protected function getEntityClass(): string
    {
        return  File::class;
    }

    protected function getAlias(): string
    {
        return 'f';
    }
}
