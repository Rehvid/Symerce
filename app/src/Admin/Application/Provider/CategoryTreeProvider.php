<?php

declare(strict_types=1);

namespace App\Admin\Application\Provider;

use App\Admin\Domain\Service\CategoryTreeBuilderInterface;
use App\Entity\Category;

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
