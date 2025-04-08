<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Category;
use App\Repository\CategoryRepository;

final class CategoryTreeBuilder
{
    /** @param array<int, bool> $processedCategories  */
    public function __construct(
        private readonly CategoryRepository $categoryRepository,
        private array $processedCategories = []
    ) {

    }

    /** @return list<array<string, mixed>> */
    public function generateTree(): array
    {
        $tree = [];
        $categories = $this->categoryRepository->findAll();

        /** @var Category $category */
        foreach ($categories as $category) {
            if (isset($this->processedCategories[$category->getId()])) {
                continue;
            }

            $tree[] = $this->buildTreeNode($category, false);
        }

        return $tree;
    }

    /** @return array<string, mixed> */
    private function buildTreeNode(Category $category, bool $isRecursive): array
    {
        if ($isRecursive) {
            $this->processedCategories[$category->getId()] = true;
        }

        /** @var Category[] $children */
        $children = array_map(fn ($child) => $this->buildTreeNode($child, true), $category->getChildren()->toArray());

        return [
            'id' => $category->getId(),
            'name' => $category->getName(),
            'children' => $children,
        ];
    }
}
