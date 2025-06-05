<?php

declare(strict_types=1);

namespace App\Common\Application\Search\Contracts;

interface FilterSingleDefinitionInterface extends FilterDefinitionInterface
{
    public function castValue(mixed $rawValue): mixed;

    public function getRequestName(): string;
}
