<?php

declare(strict_types=1);

namespace App\Admin\Application\Hydrator\Product;

use App\Admin\Domain\Entity\Category;
use App\Admin\Domain\Entity\Product;
use App\Admin\Domain\Repository\CategoryRepositoryInterface;

final readonly class ProductCategoryHydrator
{
    public function __construct(
        private CategoryRepositoryInterface $repository,
    ) {}

    public function hydrate(array $categoryIds, int $mainCategoryId, Product $product): void
    {
        /** @var $categoryEntities Category[] */
        $categoryEntities = $this->repository->findBy(['id' => $categoryIds]);
        $product->getCategories()->clear();

        foreach ($categoryEntities as $category) {
            if ($category->getId() === $mainCategoryId) {
                $product->setMainCategory($category);
            }
            $product->addCategory($category);
        }
    }
}
