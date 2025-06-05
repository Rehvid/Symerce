<?php

declare(strict_types=1);

namespace App\Common\Application\Search\Contracts;

interface FilterMultiDefinitionInterface extends FilterDefinitionInterface
{
    public function castValues(array $rawValues): array;

    public function getRequestNames(): array;
}
