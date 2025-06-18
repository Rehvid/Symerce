<?php

declare(strict_types=1);

namespace App\Category\Application\Handler\Query\Admin;

use App\Category\Application\Assembler\Admin\CategoryAssembler;
use App\Category\Application\Query\Admin\GetCategoryCreationContextQuery;
use App\Common\Application\Query\Interfaces\QueryHandlerInterface;

final readonly class CategoryCreationContextQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private CategoryAssembler $assembler
    ) {
    }

    public function __invoke(GetCategoryCreationContextQuery $query): array
    {
        return $this->assembler->toCreateFormDataResponse();
    }
}
