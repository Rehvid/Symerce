<?php

declare(strict_types=1);

namespace App\Category\Application\Handler\Query;

use App\Category\Application\Assembler\CategoryAssembler;
use App\Category\Application\Query\GetCategoryCreationContextQuery;
use App\Shared\Application\Query\QueryHandlerInterface;

final readonly class CategoryCreationContextQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private CategoryAssembler $assembler
    ) {}

    public function __invoke(GetCategoryCreationContextQuery $query): array
    {
        return $this->assembler->toCreateFormDataResponse();
    }
}
