<?php

declare(strict_types=1);

namespace App\Service\DataPersister;

use App\Dto\Request\CreateCategoryDto;
use App\Entity\Category;
use App\Interfaces\PersistableInterface;
use App\Service\DataPersister\Base\AbstractDataPersister;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\String\Slugger\SluggerInterface;

class CategoryPersister extends AbstractDataPersister
{
    public function supports(object $persistable): bool
    {
        return $persistable instanceof CreateCategoryDto;
    }

    protected function createEntityFromDto(PersistableInterface $persistable): object
    {
        $categoryRepository = $this->entityManager->getRepository(Category::class);

        /** @var  CreateCategoryDto $persistable */
       $category = new Category();
       $category->setActive($persistable->isActive);
       $category->setName($persistable->name);
       $category->setDescription($persistable->description);
       $category->setParent($categoryRepository->find($persistable->parentId));
       $category->setSlug(strtolower($persistable->name));
       $category->setOrder($categoryRepository->count());

       return $category;
    }
}
