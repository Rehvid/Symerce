<?php

declare(strict_types=1);

namespace App\Category\Application\Handler\Query;

use App\Admin\Domain\Entity\Category;
use App\Category\Application\Assembler\CategoryAssembler;
use App\Category\Application\Query\GetCategoryForEditQuery;
use App\Category\Domain\Repository\CategoryRepositoryInterface;
use App\Shared\Application\Query\QueryHandlerInterface;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

final readonly class CategoryForEditQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private CategoryAssembler $assembler,
        private CategoryRepositoryInterface $repository,
    ) {}

    public function __invoke(GetCategoryForEditQuery $query): array
    {
        /** @var ?Category $category */
        $category = $this->repository->findById($query->categoryId);
        if (null === $category) {
            throw new NotFoundHttpException();
        }

        return $this->assembler->toFormDataResponse($category);
    }
}
