<?php

declare(strict_types=1);

namespace App\Category\Application\Handler\Query\Shop;

use App\Category\Application\Assembler\Shop\CategoryAssembler;
use App\Category\Application\Dto\Shop\Response\CategoryShowResponse;
use App\Category\Application\Query\Shop\GetCategoryBySlugQuery;
use App\Category\Domain\Repository\CategoryRepositoryInterface;
use App\Common\Application\Query\Interfaces\QueryHandlerInterface;
use App\Common\Domain\Exception\EntityNotFoundException;

final readonly class CategoryBySlugQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private CategoryRepositoryInterface $repository,
        private CategoryAssembler $assembler
    ) {}

    public function __invoke(GetCategoryBySlugQuery $categoryBySlugQuery): CategoryShowResponse
    {
        $category = $this->repository->findBySlug($categoryBySlugQuery->slug);
        if (null === $category) {
            throw EntityNotFoundException::forField('Category', 'slug', $categoryBySlugQuery->slug);
        }

        return $this->assembler->toShowResponse($category);
    }
}
