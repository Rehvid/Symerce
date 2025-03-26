<?php

declare(strict_types=1);

namespace App\Service\DataPersister;

use App\Dto\Request\Category\SaveCategoryDto;
use App\Entity\Category;
use App\Interfaces\PersistableInterface;
use App\Service\DataPersister\Base\AbstractDataPersister;
use App\Service\SluggerService;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

final class CategoryPersister extends AbstractDataPersister
{
    public function __construct(
        private readonly SluggerService $sluggerService,
        EntityManagerInterface $entityManager
    ) {
        parent::__construct($entityManager);
    }

    public function getSupportedClasses(): array
    {
        return [SaveCategoryDto::class, Category::class];
    }

    protected function createEntityFromDto(PersistableInterface $persistable): object
    {
        /** @var SaveCategoryDto $persistable */
        $category = new Category();
        $category->setActive($persistable->isActive);
        $category->setName($persistable->name);
        $category->setDescription($persistable->description);
        $category->setParent($this->getParentCategory($persistable->parentId));
        $category->setSlug($this->generateSlug($persistable->name));
        $category->setOrder($this->getRepository()->count());

        return $category;
    }

    /**
     * @param Category        $entity
     * @param SaveCategoryDto $persistable
     */
    protected function updateEntityFromDto(object $entity, PersistableInterface $persistable): object
    {
        if ($entity->getName() !== $persistable->name) {
            $entity->setSlug($this->generateSlug($persistable->name));
        }

        $entity->setName($persistable->name);
        $entity->setActive($persistable->isActive);
        $entity->setDescription($persistable->description);
        $entity->setParent($this->getParentCategory($persistable->parentId));

        return $entity;
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
