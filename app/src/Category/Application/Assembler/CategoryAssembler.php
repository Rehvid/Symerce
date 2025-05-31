<?php

declare(strict_types=1);

namespace App\Category\Application\Assembler;

use App\Admin\Application\Assembler\Helper\ResponseHelperAssembler;
use App\Admin\Domain\Entity\Category;
use App\Category\Application\Dto\Response\CategoryFormResponse;
use App\Category\Application\Dto\Response\CategoryListResponse;
use App\Category\Application\Dto\Response\CategoryTreeResponse;
use App\Category\Application\Provider\CategoryTreeProvider;

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
        return $this->responseHelperAssembler->wrapFormResponse(
            context: new CategoryTreeResponse(
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
        $image = $category->getFile();

        $file = $image === null
            ? null
            : $this->responseHelperAssembler->toFileResponse($image->getId(), $name, $image->getPath());

        return $this->responseHelperAssembler->wrapFormResponse(
            data: new CategoryFormResponse(
                name: $category->getName(),
                slug: $category->getSlug(),
                metaTitle: $category->getMetaTitle(),
                metaDescription: $category->getMetaDescription(),
                isActive: $category->isActive(),
                parentCategoryId: $category->getParent()?->getId(),
                description: $category->getDescription(),
                thumbnail: $file,
            ),
            context: [
                'tree' => $this->treeProvider->provide($category)
            ]
        );
    }

    private function createCategoryListResponse(Category $category): CategoryListResponse
    {
        return new CategoryListResponse(
            id: $category->getId(),
            name: $category->getName(),
            slug: $category->getSlug(),
            isActive: $category->isActive(),
            imagePath: $this->responseHelperAssembler->buildPublicFilePath($category->getFile()?->getPath()),
        );
    }
}
