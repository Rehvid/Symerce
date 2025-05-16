<?php

declare(strict_types=1);

namespace App\Admin\Domain\Repository;

interface PersistableRepositoryInterface
{
    public function save(object $entity): void;
    public function remove(object $entity): void;
}
