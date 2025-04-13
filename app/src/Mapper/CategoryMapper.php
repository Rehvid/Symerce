<?php

declare(strict_types=1);

namespace App\Mapper;

use App\DTO\Response\Category\CategoryFormResponseDTO;
use App\DTO\Response\Category\CategoryIndexResponseDTO;
use App\DTO\Response\FileResponseDTO;
use App\Entity\Category;
use App\Service\CategoryTreeBuilder;
use App\Service\FileService;

final readonly class CategoryMapper
{
    public function __construct(private FileService $fileService)
    {
    }

    /** @param array<string, mixed> $categoryData */
    public function mapToIndexResponse(array $categoryData): CategoryIndexResponseDTO
    {
        if ($categoryData['path']) {
            $categoryData['imagePath'] = $this->fileService->preparePublicPathToFile($categoryData['path']);
        }

        return CategoryIndexResponseDTO::fromArray($categoryData);
    }

    public function mapToFormData(CategoryTreeBuilder $tree, Category $category): CategoryFormResponseDTO
    {
        $name = $category->getName();

        $dataResponse = [
            'tree' => $tree->generateTree(),
            'name' => $name,
            'slug' => $category->getSlug(),
            'parentCategoryId' => $category->getParent()?->getId(),
            'description' => $category->getDescription(),
            'isActive' => $category->isActive(),
        ];

        if (null !== $category->getImage()) {
            $dataResponse['image'] = FileResponseDTO::fromArray([
                    'id' => $category->getImage()->getId(),
                    'name' => $name,
                    'preview' => $this->fileService->preparePublicPathToFile($category->getImage()->getPath()),
                ])
            ;
        }

        return CategoryFormResponseDTO::fromArray($dataResponse);
    }
}
