<?php

declare(strict_types=1);

namespace App\Service\DataPersister\Persisters\Category;

use App\Dto\Request\Category\SaveCategoryRequestDTO;
use App\Entity\Category;
use App\Interfaces\PersistableInterface;
use App\Service\DataPersister\Base\UpdatePersister;
use App\Service\SluggerService;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

final class CategoryUpdatePersister extends UpdatePersister
{
    public function __construct(
        private readonly SluggerService $sluggerService,
        EntityManagerInterface $entityManager
    ) {
        parent::__construct($entityManager);
    }

    protected function updateEntity(PersistableInterface $persistable, object $entity): object
    {
        /** @var SaveCategoryRequestDTO $persistable */
        /** @var Category $entity */

        if ($entity->getName() !== $persistable->name) {
            $entity->setSlug($this->generateSlug($persistable->name));
        }

        $entity->setName($persistable->name);
        $entity->setActive($persistable->isActive);
        $entity->setDescription($persistable->description);
        $entity->setParent($this->getParentCategory($persistable->parentId));

        return $entity;
    }

    public function getSupportedClasses(): array
    {
        return [SaveCategoryRequestDTO::class, Category::class];
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
