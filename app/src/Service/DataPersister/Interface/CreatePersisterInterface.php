<?php

declare(strict_types=1);

namespace App\Service\DataPersister\Interface;

use App\Interfaces\PersistableInterface;

interface CreatePersisterInterface extends DataPersisterInterface
{
    public function persist(PersistableInterface $persistable): object;
}
