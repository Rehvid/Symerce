<?php

declare(strict_types=1);

namespace App\Mapper\Admin;

use App\Admin\Domain\Service\CategoryTreeBuilder;
use App\DTO\Admin\Response\Category\CategoryFormResponseDTO;
use App\DTO\Admin\Response\Category\CategoryIndexResponseDTO;
use App\DTO\Admin\Response\ResponseInterfaceData;
use App\Entity\Category;
use App\Mapper\Helper\ResponseMapperHelper;
use App\Mapper\Interfaces\ResponseMapperInterface;

final readonly class CategoryResponseMapper implements ResponseMapperInterface
{
    public function __construct(
        private CategoryTreeBuilder $treeBuilder,
        private ResponseMapperHelper $responseMapperHelper,
    ) {
    }

    public function mapToIndexResponse(array $data = []): array
    {
        return $this->responseMapperHelper->prepareIndexFormDataResponse(
            array_map(fn (Category $category) => $this->createCategoryIndexResponse($category), $data)
        );
    }

    private function createCategoryIndexResponse(Category $category): ResponseInterfaceData
    {
        return CategoryIndexResponseDTO::fromArray([
            'id' => $category->getId(),
            'name' => $category->getName(),
            'isActive' => $category->isActive(),
            'slug' => $category->getSlug(),
            'imagePath' => $this->responseMapperHelper->buildPublicFilePath($category->getImage()?->getPath()),
        ]);
    }

    /**
     * @return array<string, mixed>
     */
    public function mapToStoreFormDataResponse(): array
    {
        $response = CategoryFormResponseDTO::fromArray([
            'tree' => $this->treeBuilder->generateTree(),
        ]);

        return $this->responseMapperHelper->prepareFormDataResponse($response);
    }

    public function mapToUpdateFormDataResponse(array $data = []): array
    {
        /** @var Category $category */
        $category = $data['entity'];

        $name = $category->getName();
        $image = $category->getImage();

        $response = CategoryFormResponseDTO::fromArray([
            'tree' => $this->treeBuilder->generateTree($category),
            'name' => $name,
            'slug' => $category->getSlug(),
            'parentCategoryId' => $category->getParent()?->getId(),
            'description' => $category->getDescription(),
            'isActive' => $category->isActive(),
            'image' => $this->responseMapperHelper->createFileResponseData($image?->getId(), $name, $image?->getPath()),
        ]);

        return $this->responseMapperHelper->prepareFormDataResponse($response);
    }
}
