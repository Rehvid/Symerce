<?php

declare(strict_types=1);

namespace App\Admin\Application\Assembler;

use App\Admin\Application\Assembler\Helper\ResponseHelperAssembler;
use App\Admin\Application\DTO\Response\Category\CategoryFormResponse;
use App\Admin\Application\DTO\Response\Category\CategoryListResponse;
use App\Admin\Application\DTO\Response\Category\CategoryTreeResponse;
use App\Admin\Application\Provider\CategoryTreeProvider;
use App\Entity\Category;

final readonly class CategoryAssembler
{
    public function __construct(
        private ResponseHelperAssembler $responseHelperAssembler,
        private CategoryTreeProvider  $treeProvider,
    ) {

    }

    /**
     * @param array<int, mixed> $paginatedData
     * @return array<string, mixed>
     */
    public function toListResponse(array $paginatedData): array
    {
        $categoryListCollection = array_map(
            fn (Category $category) => $this->createCategoryListResponse($category),
            $paginatedData
        );


        return $this->responseHelperAssembler->wrapListWithAdditionalData($categoryListCollection);
    }

    public function toCreateFormDataResponse(): array
    {
        return $this->responseHelperAssembler->wrapAsFormData(
            new CategoryTreeResponse(
                tree: $this->treeProvider->provide()
            )
        );
    }


    /**
     * @return array<string, mixed>
     */
    public function toFormDataResponse(Category $category): array
    {
        $name = $category->getName();
        $image = $category->getImage();

        $file = $image === null
            ? null
            : $this->responseHelperAssembler->toFileResponse($image->getId(), $name, $image->getPath());

        return $this->responseHelperAssembler->wrapAsFormData(
            new CategoryFormResponse(
                name: $category->getName(),
                slug: $category->getSlug(),
                isActive: $category->isActive(),
                parentCategoryId: $category->getParent()?->getId(),
                description: $category->getDescription(),
                image: $file,
                tree: $this->treeProvider->provide($category),
            )
        );
    }

    private function createCategoryListResponse(Category $category): CategoryListResponse
    {
        return new CategoryListResponse(
            id: $category->getId(),
            name: $category->getName(),
            slug: $category->getSlug(),
            isActive: $category->isActive(),
            imagePath: $this->responseHelperAssembler->buildPublicFilePath($category->getImage()?->getPath()),
        );
    }
}
