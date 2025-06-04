<?php

declare(strict_types=1);

namespace App\Product\Application\Handler\Query;

use App\Common\Application\Query\Interfaces\QueryHandlerInterface;
use App\Product\Application\Assembler\ProductAssembler;
use App\Product\Application\Query\GetProductCreationContextQuery;

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
