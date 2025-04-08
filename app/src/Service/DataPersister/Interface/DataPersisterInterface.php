<?php

declare(strict_types=1);

namespace App\Service\DataPersister\Interface;

interface DataPersisterInterface
{
    /** @return array<int, string> */
    public function getSupportedClasses(): array;
}
