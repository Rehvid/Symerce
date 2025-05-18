<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\File;
use App\Shared\Infrastructure\Repository\DoctrineRepository;


class FileRepository extends DoctrineRepository
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
