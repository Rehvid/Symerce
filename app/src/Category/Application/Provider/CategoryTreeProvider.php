<?php

declare(strict_types=1);

namespace App\Category\Application\Provider;

use App\Admin\Domain\Entity\Category;
use App\Category\Domain\Service\CategoryTreeBuilderInterface;

final readonly class CategoryTreeProvider
{
    public function __construct(
        private CategoryTreeBuilderInterface $categoryTreeBuilder,
    ) {
    }

    public function provide(?Category $exclude = null): array
    {
        return $this->categoryTreeBuilder->generateTree($exclude);
    }
}
