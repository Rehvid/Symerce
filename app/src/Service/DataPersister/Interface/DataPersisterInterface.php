<?php

namespace App\Service\DataPersister\Interface;

use App\Interfaces\PersistableInterface;

interface DataPersisterInterface
{
    public function getSupportedClasses(): array;

    public function persist(PersistableInterface $persistable): object;

    public function update(object $entity, PersistableInterface $data): object;

    public function delete(object $entity): void;
}
