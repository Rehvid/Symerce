<?php

declare(strict_types=1);

namespace App\Service\DataPersister\Persisters\Category;

use App\DTO\Request\Category\SaveCategoryRequestDTO;
use App\Entity\Category;
use App\Interfaces\PersistableInterface;
use App\Service\DataPersister\Base\UpdatePersister;
use App\Service\DataPersister\PersisterHelper\CategoryPersisterHelper;
use App\Service\FileService;
use Doctrine\ORM\EntityManagerInterface;

final class CategoryUpdatePersister extends UpdatePersister
{
    public function __construct(
        private readonly CategoryPersisterHelper $categoryPersisterHelper,
        private readonly FileService $fileService,
        EntityManagerInterface $entityManager
    ) {
        parent::__construct($entityManager);
    }

    protected function updateEntity(PersistableInterface $persistable, object $entity): object
    {
        /** @var SaveCategoryRequestDTO $persistable */
        /** @var Category $entity */
        if ($entity->getSlug() !== $persistable->slug) {
            $entity->setSlug(
                $this->categoryPersisterHelper->generateSlug($persistable->slug)
            );
        }

        $entity->setName($persistable->name);
        $entity->setActive($persistable->isActive);
        $entity->setDescription($persistable->description);
        $entity->setParent(
            $this->categoryPersisterHelper->getParentCategory($persistable->parentCategoryId, $this->entityManager)
        );

        if (!empty($persistable->image)) {
            foreach ($persistable->image as $image) {
                $entity->setImage($this->fileService->processFileRequestDTO($image, $entity->getImage()));
            }
        }

        return $entity;
    }

    public function getSupportedClasses(): array
    {
        return [SaveCategoryRequestDTO::class, Category::class];
    }
}
