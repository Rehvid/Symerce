<?php

declare(strict_types=1);

namespace App\Category\Application\Handler\Query\Shop;

use App\Category\Application\Assembler\Shop\CategoryAssembler;
use App\Category\Application\Dto\Shop\Response\CategoryListResponseCollection;
use App\Category\Application\Query\Shop\GetCategoryListQuery;
use App\Common\Application\Query\Interfaces\QueryHandlerInterface;

final readonly class CategoryListQueryHandler implements QueryHandlerInterface
{
    public function __construct(private CategoryAssembler $assembler) {}

    public function __invoke(GetCategoryListQuery $categoryListQuery): CategoryListResponseCollection
    {
        return $this->assembler->toListResponse();
    }
}
