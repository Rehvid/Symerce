<?php

declare (strict_types = 1);

namespace App\Service\DataPersister\Persisters\Category;

use App\Dto\Request\Category\SaveCategoryRequestDTO;
use App\Entity\Category;
use App\Interfaces\PersistableInterface;
use App\Service\DataPersister\Base\CreatePersister;
use App\Service\SluggerService;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

final class CategoryCreatePersister extends CreatePersister
{
    public function __construct(
        private readonly SluggerService $sluggerService,
        EntityManagerInterface $entityManager
    ) {
        parent::__construct($entityManager);
    }


    protected function createEntity(PersistableInterface $persistable): object
    {
        /** @var SaveCategoryRequestDTO $persistable */

        $category = new Category();
        $category->setActive($persistable->isActive);
        $category->setName($persistable->name);
        $category->setDescription($persistable->description);
        $category->setParent($this->getParentCategory($persistable->parentId));
        $category->setSlug($this->generateSlug($persistable->name));
        $category->setOrder($this->getRepository()->count());

        return $category;
    }

    public function getSupportedClasses(): array
    {
        return [SaveCategoryRequestDTO::class];
    }

    private function getParentCategory(?int $parentId): ?Category
    {
        return $parentId ? $this->getRepository()->find($parentId) : null;
    }

    private function generateSlug(string $name): string
    {
        return $this->sluggerService->slugifyUnique($name, Category::class, 'slug');
    }

    private function getRepository(): EntityRepository
    {
        return $this->entityManager->getRepository(Category::class);
    }
}
