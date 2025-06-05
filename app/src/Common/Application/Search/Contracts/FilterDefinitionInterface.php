<?php

declare(strict_types=1);

namespace App\Common\Application\Search\Contracts;

use App\Common\Domain\Enums\QueryOperator;

interface FilterDefinitionInterface
{
    public function getField(): string;

    public function getOperator(): QueryOperator;
}
