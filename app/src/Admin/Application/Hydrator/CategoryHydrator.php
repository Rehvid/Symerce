<?php

declare(strict_types=1);

namespace App\Admin\Application\Hydrator;

use App\Admin\Application\DTO\Request\Category\SaveCategoryRequest;
use App\Admin\Application\Service\FileService;
use App\Admin\Domain\Entity\Category;
use App\Admin\Domain\Model\FileData;
use App\Admin\Domain\Repository\CategoryRepositoryInterface;
use App\Admin\Infrastructure\Slug\SluggerService;

final readonly class CategoryHydrator
{
    public function __construct(
        private FileService $fileService,
        private SluggerService $sluggerService,
        private CategoryRepositoryInterface $repository,
    ) {
    }

    public function hydrate(SaveCategoryRequest $request, Category $category): Category
    {
        $category->setActive($request->isActive);
        $category->setName($request->name);
        $category->setDescription($request->description);

        $this->setParent($request, $category);
        $this->setImage($request->fileData, $category);

        return $category;
    }

    public function saveSlug(string $name, ?string $slug): string
    {
        if (null === $slug || '' === $slug) {
            return $this->generateSlug($name);
        }

        return $this->generateSlug($slug);
    }

    public function generateSlug(string $name): string
    {
        return $this->sluggerService->slugifyUnique($name, Category::class, 'slug');
    }

    private function setParent(SaveCategoryRequest $request, Category $category): void
    {
        if (null === $request->parentCategoryId) {
            return;
        }

        /** @var Category|null $parentCategory */
        $parentCategory = $this->repository->find($request->parentCategoryId);
        $category->setParent($parentCategory);
    }

    private function setImage(?FileData $fileData, Category $category): void
    {
        if (null === $fileData) {
            return;
        }

        $this->fileService->replaceFile($category, $fileData);
    }

}
