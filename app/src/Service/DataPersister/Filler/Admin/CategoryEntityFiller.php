<?php

declare(strict_types=1);

namespace App\Service\DataPersister\Filler\Admin;

use App\DTO\Admin\Request\Category\SaveCategoryRequestDTO;
use App\DTO\Admin\Request\PersistableInterface;
use App\Entity\Category;
use App\Repository\CategoryRepository;
use App\Service\DataPersister\Filler\Base\BaseEntityFiller;
use App\Service\FileService;
use App\Service\SluggerService;

/**
 * @extends BaseEntityFiller<SaveCategoryRequestDTO>
 */
final class CategoryEntityFiller extends BaseEntityFiller
{
    public function __construct(
        private readonly SluggerService $sluggerService,
        private readonly CategoryRepository $categoryRepository,
        private readonly FileService $fileService
    ) {
    }

    public static function supports(): string
    {
        return SaveCategoryRequestDTO::class;
    }

    public function toNewEntity(PersistableInterface|SaveCategoryRequestDTO $persistable): Category
    {
        $entity = new Category();
        $entity->setSlug($this->saveSlug($persistable->name, $persistable->slug));
        $entity->setOrder($this->categoryRepository->count());

        return $this->fillEntity($persistable, $entity);
    }

    /**
     * @param Category $entity
     */
    public function toExistingEntity(PersistableInterface|SaveCategoryRequestDTO $persistable, object $entity): Category
    {
        if (null !== $persistable->slug && $entity->getSlug() !== $persistable->slug) {
            $entity->setSlug($this->generateSlug($persistable->slug));
        }

        return $this->fillEntity($persistable, $entity);
    }

    /**
     * @param Category $entity
     */
    protected function fillEntity(SaveCategoryRequestDTO|PersistableInterface $persistable, object $entity): Category
    {
        $entity->setActive($persistable->isActive);
        $entity->setName($persistable->name);
        $entity->setDescription($persistable->description);

        /** @var Category|null $parentCategory */
        $parentCategory = $this->categoryRepository->find($persistable->parentCategoryId);
        $entity->setParent($parentCategory);

        if (!empty($persistable->image)) {
            foreach ($persistable->image as $image) {
                $entity->setImage($this->fileService->processFileRequestDTO($image, $entity->getImage()));
            }
        }

        return $entity;
    }

    private function saveSlug(string $name, ?string $slug): string
    {
        if (null === $slug) {
            return $this->generateSlug($name);
        }

        return $this->generateSlug($slug);
    }

    public function generateSlug(string $name): string
    {
        return $this->sluggerService->slugifyUnique($name, Category::class, 'slug');
    }
}
