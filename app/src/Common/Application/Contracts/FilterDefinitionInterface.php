<?php

declare(strict_types=1);

namespace App\Common\Application\Contracts;

use App\Common\Domain\Enums\QueryOperator;
use Symfony\Component\HttpFoundation\Request;

interface FilterDefinitionInterface
{
    public function getField(): string;

    public function getRequestNames(): array;

    public function getOperator(): QueryOperator;
    public function castValue(mixed $rawValue): mixed;

    public function isMultiValue(): bool;

    public function castFromRequest(Request $request): mixed;
}
