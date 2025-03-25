<?php

declare(strict_types=1);

namespace App\Service;

use App\Entity\Category;
use App\Repository\CategoryRepository;

class CategoryTreeBuilder
{

    public function __construct(
        private readonly CategoryRepository $categoryRepository,
        private array $processedCategories = []
    ){

    }

    public function generateTree(): array
    {
        $tree = [];
        $categories = $this->categoryRepository->findAll();

        foreach ($categories as $category) {
            if (isset($this->processedCategories[$category->getId()])) {
                continue;
            }

            $tree[] = $this->buildTreeNode($category);
        }

        return $tree;
    }

    private function buildTreeNode(Category $category, bool $isRecursive = false): array
    {
        if ($isRecursive) {
            $this->processedCategories[$category->getId()] = true;
        }

        return [
            'id' => $category->getId(),
            'name' => $category->getName(),
            'children' => array_map(fn($child) => $this->buildTreeNode($child,true), $category->getChildren()->toArray()),
        ];
    }
}
