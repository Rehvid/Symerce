<?php

declare(strict_types=1);

namespace App\Category\Application\Factory;

use App\Category\Application\Dto\CategoryData;
use App\Category\Application\Dto\Request\SaveCategoryRequest;
use App\Category\Domain\Repository\CategoryRepositoryInterface;
use App\Shared\Application\Factory\ValidationExceptionFactory;

final readonly class CategoryDataFactory
{
    public function __construct(
        private CategoryRepositoryInterface $categoryRepository,
        private ValidationExceptionFactory $validationExceptionFactory
    ) {}

    public function fromRequest(SaveCategoryRequest $categoryRequest): CategoryData
    {
        $parentCategory = $this->categoryRepository->findById($categoryRequest->parentCategoryId);
        if (null === $parentCategory) {
            $this->validationExceptionFactory->createNotFound('parentCategoryId');
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
