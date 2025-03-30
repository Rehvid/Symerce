<?php

namespace App\Service\DataPersister\Interface;

use App\Interfaces\PersistableInterface;

interface DataPersisterInterface
{
    public function getSupportedClasses(): array;
}
