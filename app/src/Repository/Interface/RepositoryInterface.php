<?php

declare(strict_types=1);

namespace App\Repository\Interface;

interface RepositoryInterface
{
    public function save(object $entity): void;
    public function remove(object $entity): void;
}
