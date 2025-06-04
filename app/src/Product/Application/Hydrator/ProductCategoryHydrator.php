<?php

declare(strict_types=1);

namespace App\Product\Application\Hydrator;

use App\Common\Domain\Entity\Category;
use App\Common\Domain\Entity\Product;

final readonly class ProductCategoryHydrator
{
    /** @param Category[] $categoriesData */
    public function hydrate(array $categoriesData, Product $product): void
    {
        $product->getCategories()->clear();

        foreach ($categoriesData as $category) {
            $product->addCategory($category);
        }
    }
}
