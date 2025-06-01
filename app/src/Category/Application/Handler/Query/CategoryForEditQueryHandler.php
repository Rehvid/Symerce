<?php

declare(strict_types=1);

namespace App\Category\Application\Handler\Query;

use App\Category\Application\Assembler\CategoryAssembler;
use App\Category\Application\Query\GetCategoryForEditQuery;
use App\Category\Domain\Repository\CategoryRepositoryInterface;
use App\Common\Domain\Entity\Category;
use App\Common\Domain\Exception\EntityNotFoundException;
use App\Shared\Application\Query\QueryHandlerInterface;

final readonly class CategoryForEditQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private CategoryAssembler $assembler,
        private CategoryRepositoryInterface $repository,
    ) {}

    public function __invoke(GetCategoryForEditQuery $query): array
    {
        /** @var Category $category */
        $category = $this->repository->findById($query->categoryId);
        if (null === $category) {
            throw EntityNotFoundException::for(Category::class, $query->categoryId);
        }

        return $this->assembler->toFormDataResponse($category);
    }
}
