<?php

declare(strict_types=1);

namespace App\Category\Domain\Service;

use App\Category\Domain\Repository\CategoryRepositoryInterface;
use App\Common\Domain\Entity\Category;

final class CategoryTreeBuilder implements CategoryTreeBuilderInterface
{
    /**
     * @var array<int, bool>
     */
    private array $processedCategories = [];

    public function __construct(
        private readonly CategoryRepositoryInterface $categoryRepository
    ) {

    }

    /** @return list<array<string, mixed>> */
    public function generateTree(?Category $currentCategory = null): array
    {
        $tree = [];

        $excludedIds = [];
        if (null !== $currentCategory) {
            $excludedIds = $this->collectDescendantIds($currentCategory);

            $currentId = $currentCategory->getId();
            if ($currentId !== null) {
                $excludedIds[] = (int) $currentId;
            }
        }

        $categories = $this->categoryRepository->findAllSortedByPosition();
        foreach ($categories as $category) {
            $id = $category->getId();
            if ($id === null) {
                continue;
            }
            $id = (int) $id;

            if (
                null === $category->getParent()
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

        if ($categoryId === null) {
            return [];
        }

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
            $childId = $child->getId();
            if ($childId === null) {
                continue;
            }
            $ids[] = $childId;
            $ids = array_merge($ids, $this->collectDescendantIds($child));
        }

        return $ids;
    }
}
