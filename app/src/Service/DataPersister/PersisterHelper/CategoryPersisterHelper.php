<?php

declare(strict_types=1);

namespace App\Service\DataPersister\PersisterHelper;

use App\Entity\Category;
use App\Service\SluggerService;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\EntityRepository;

final readonly class CategoryPersisterHelper
{
    public function __construct(
        private SluggerService $sluggerService
    ) {

    }

    public function getParentCategory(string|int|null $parentId, EntityManagerInterface $entityManager): ?Category
    {
        return $parentId ? $this->getRepository($entityManager)->find($parentId) : null;
    }

    public function generateSlug(string $name): string
    {
        return $this->sluggerService->slugifyUnique($name, Category::class, 'slug');
    }

    /** @return EntityRepository<Category> */
    public function getRepository(EntityManagerInterface $entityManager): EntityRepository
    {
        return $entityManager->getRepository(Category::class);
    }
}
