<?php

declare(strict_types=1);

namespace App\Service\DataPersister\Persisters\Category;

use App\DTO\Request\Category\SaveCategoryRequestDTO;
use App\Entity\Category;
use App\Interfaces\PersistableInterface;
use App\Service\DataPersister\Base\CreatePersister;
use App\Service\DataPersister\PersisterHelper\CategoryPersisterHelper;
use Doctrine\ORM\EntityManagerInterface;

final class CategoryCreatePersister extends CreatePersister
{
    public function __construct(
        private readonly CategoryPersisterHelper $categoryPersisterHelper,
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
        $category->setParent(
            $this->categoryPersisterHelper->getParentCategory($persistable->parentCategoryId, $this->entityManager)
        );

        $category->setSlug($this->saveSlug($persistable->name, $persistable->slug));
        $category->setOrder(
            $this->categoryPersisterHelper->getRepository($this->entityManager)->count()
        );

        return $category;
    }

    /** @return array<int, string> */
    public function getSupportedClasses(): array
    {
        return [SaveCategoryRequestDTO::class];
    }

    private function saveSlug(string $name, ?string $slug): string
    {
        if ($slug === null) {
            return $this->categoryPersisterHelper->generateSlug($name);
        }

        return $this->categoryPersisterHelper->generateSlug($slug);
    }
}
