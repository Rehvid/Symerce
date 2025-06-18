<?php

declare(strict_types=1);

namespace App\Category\Application\Dto\Shop\Response;

use App\Common\Domain\Entity\Category;
use App\Product\Application\Dto\Shop\Response\ProductListResponse;

final readonly class CategoryShowResponse
{

    /**
     * @param CategorySubcategoryListResponse[] $subcategoryListResponseCollection
     * @param ProductListResponse[] $productListResponseCollection
     */
    public function __construct(
        public Category $category,
        public array $subcategoryListResponseCollection,
        public array $productListResponseCollection,
    ) {}
}
