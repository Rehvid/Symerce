<?php

declare(strict_types=1);

namespace App\Admin\Application\Hydrator\Product;

use App\Category\Domain\Repository\CategoryRepositoryInterface;
use App\Common\Domain\Entity\Category;
use App\Common\Domain\Entity\Product;

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
