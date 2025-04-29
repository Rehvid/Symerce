<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Category;
use App\Repository\CategoryRepository;

final class CategoryTreeBuilder
{
    /**
     * @var array<int, bool>
     */
    private array $processedCategories = [];

    public function __construct(private readonly CategoryRepository $categoryRepository)
    {
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

        /** @var Category[] $categories */
        $categories = $this->categoryRepository->findAll();
        foreach ($categories as $category) {
            $id = $category->getId();

            if (
                null === $category->getParent()
                /* @phpstan-ignore-next-line */
                && !isset($this->processedCategories[$id])
                && !in_array($id, $excludedIds, true)
            ) {
                $tree[] = $this->buildTreeNode($category, [], $excludedIds);
            }
        }

        return $tree;
    }

    /**
     * @param list<int> $path
     * @param list<int> $excludedIds
     *
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
            fn (Category $child) => $this->buildTreeNode($child, $newPath, $excludedIds),
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
