<?php

declare(strict_types=1);

namespace App\Category\Application\Factory;

use App\Category\Application\Dto\CategoryData;
use App\Category\Application\Dto\Request\SaveCategoryRequest;
use App\Category\Domain\Repository\CategoryRepositoryInterface;
use App\Common\Domain\Entity\Category;
use App\Common\Domain\Exception\EntityNotFoundException;

final readonly class CategoryDataFactory
{
    public function __construct(
        private CategoryRepositoryInterface $categoryRepository,
    ) {
    }

    public function fromRequest(SaveCategoryRequest $categoryRequest): CategoryData
    {
        $parentCategoryId = $categoryRequest->parentCategoryIdRequest->getId();

        /** @var ?Category $parentCategory */
        $parentCategory = $this->categoryRepository->findById($parentCategoryId);
        if (null === $parentCategory) {
            throw EntityNotFoundException::for(Category::class, $parentCategoryId);
        }

        return new CategoryData(
            name: $categoryRequest->name,
            isActive: $categoryRequest->isActive,
            parentCategory: $parentCategory,
            metaTitle: $categoryRequest->metaTitle,
            metaDescription: $categoryRequest->metaDescription,
            slug: $categoryRequest->slug,
            description: $categoryRequest->description,
            fileData: $categoryRequest->fileData,
        );
    }
}
