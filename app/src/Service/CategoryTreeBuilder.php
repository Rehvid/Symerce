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
    public function generateTree(?Category $currentCategory = null): array
    {
        $tree = [];
        $this->processedCategories = [];


        $excludedIds = [];
        if (null !== $currentCategory) {
            $excludedIds = $this->collectDescendantIds($currentCategory);
            $excludedIds[] = $currentCategory->getId();
        }

        $categories = $this->categoryRepository->findAll();
        foreach ($categories as $category) {
            if (
                $category->getParent() === null &&
                !isset($this->processedCategories[$category->getId()]) &&
                !in_array($category->getId(), $excludedIds, true)
            ) {
                $tree[] = $this->buildTreeNode($category, [], $excludedIds);
            }
        }

        return $tree;
    }

    /**
     * @param list<int> $path
     * @param list<int> $excludedIds
     * @return array<string, mixed>
     */
    private function buildTreeNode(Category $category, array $path, array $excludedIds): array
    {
        $categoryId = $category->getId();

        if (in_array($categoryId, $excludedIds, true)) {
            return [];
        }

        if (in_array($categoryId, $path, true)) {
            return [
                'id' => $categoryId,
                'name' => $category->getName(),
                'children' => [],
            ];
        }

        $this->processedCategories[$categoryId] = true;

        $newPath = [...$path, $categoryId];

        $children = array_filter(array_map(
            fn(Category $child) => $this->buildTreeNode($child, $newPath, $excludedIds),
            $category->getChildren()->toArray()
        ));

        return [
            'id' => $categoryId,
            'name' => $category->getName(),
            'children' => array_values($children),
        ];
    }

    /**
     * @return list<int>
     */
    private function collectDescendantIds(Category $category): array
    {
        $ids = [];

        foreach ($category->getChildren() as $child) {
            $ids[] = $child->getId();
            $ids = array_merge($ids, $this->collectDescendantIds($child));
        }

        return $ids;
    }
}
