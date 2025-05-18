<?php

declare(strict_types=1);

namespace App\Repository;

use App\Entity\File;
use App\Shared\Infrastructure\Repository\DoctrinePersistableRepository;


class FileRepository extends DoctrinePersistableRepository
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
