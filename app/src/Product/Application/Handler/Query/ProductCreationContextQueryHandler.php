<?php

declare(strict_types=1);

namespace App\Product\Application\Handler\Query;

use App\Product\Application\Assembler\ProductAssembler;
use App\Product\Application\Query\GetProductCreationContextQuery;
use App\Shared\Application\Query\QueryHandlerInterface;

final readonly class ProductCreationContextQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private ProductAssembler $assembler,
    ) {}

    public function __invoke(GetProductCreationContextQuery $query): array
    {
        return $this->assembler->toCreateFormDataResponse();
    }
}
