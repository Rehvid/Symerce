<?php

declare(strict_types=1);

namespace App\Common\Domain\Repository;

interface ReadWriteRepositoryInterface
{
    public function save(object $entity): void;

    public function remove(object $entity): void;

    public function removeCollection(array $entities): void;
}
