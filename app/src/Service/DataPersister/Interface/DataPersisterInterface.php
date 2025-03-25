<?php

namespace App\Service\DataPersister\Interface;

use App\Interfaces\PersistableInterface;

interface DataPersisterInterface
{
    public function supports(object $persistable): bool;
    public function persist(PersistableInterface $persistable): object;
}
