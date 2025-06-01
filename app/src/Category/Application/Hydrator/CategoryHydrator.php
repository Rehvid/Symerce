<?php

declare(strict_types=1);

namespace App\Category\Application\Hydrator;

use App\Admin\Application\Service\FileService;
use App\Admin\Domain\Model\FileData;
use App\Category\Application\Dto\CategoryData;
use App\Common\Domain\Entity\Category;

final readonly class CategoryHydrator
{
    public function __construct(
        private FileService $fileService,
    ) {
    }

    public function hydrate(CategoryData $data, ?Category $category = null): Category
    {
        $category ??= new Category();
        $category->setActive($data->isActive);
        $category->setName($data->name);
        $category->setDescription($data->description);
        $category->setMetaTitle($data->metaTitle);
        $category->setMetaDescription($data->metaDescription);
        $category->setParent($data->parentCategory);

        $this->setImage($data->fileData, $category);

        return $category;
    }

    private function setImage(?FileData $fileData, Category $category): void
    {
        if (null === $fileData) {
            return;
        }

        $this->fileService->replaceFile($category, $fileData);
    }

}
