<?php

declare(strict_types=1);

namespace App\Category\Application\Assembler\Shop;

use App\Category\Application\Dto\Shop\Response\CategoryListResponse;
use App\Category\Application\Dto\Shop\Response\CategoryListResponseCollection;
use App\Category\Application\Dto\Shop\Response\CategoryShowResponse;
use App\Category\Application\Dto\Shop\Response\CategorySubcategoryListResponse;
use App\Category\Domain\Repository\CategoryRepositoryInterface;
use App\Common\Application\Factory\MoneyFactory;
use App\Common\Application\Service\FileService;
use App\Common\Domain\Entity\Category;
use App\Common\Domain\Entity\Product;
use App\Product\Application\Assembler\Shop\ProductAssembler;
use App\Product\Application\Dto\Shop\Response\ProductListResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

final readonly class CategoryAssembler
{
    public function __construct(
        private CategoryRepositoryInterface $categoryRepository,
        private UrlGeneratorInterface $urlGenerator,
        private FileService $fileService,
        private ProductAssembler $productAssembler,
    ) {
    }


    public function toListResponse(): CategoryListResponseCollection
    {
        $categories = $this->categoryRepository->findActiveSortedByPosition();

        return new CategoryListResponseCollection(
            categories: array_map(
                fn (Category $category) => $this->createCategoryListResponse($category),
                $categories
            )
        );
    }

    private function createCategoryListResponse(Category $category): CategoryListResponse
    {
        return new CategoryListResponse(
            name: $category->getName(),
            slug: $category->getSlug(),
            productCount: $category->getProducts()->count(),
            imagePath: $this->fileService->preparePublicPathToFile($category->getFile()?->getPath()),
        );
    }

    public function toShowResponse(Category $category): CategoryShowResponse
    {
        $subcategoryListResponseCollection = array_map(
            fn (Category $category) => $this->createSubcategoryListResponse($category),
            $category->getChildren()->toArray()
        );

        $productListResponseCollection = array_map(
            fn (Product $product) => $this->productAssembler->toListResponse($product, $category->getSlug()),
            $category->getProducts()->toArray()
        );

        return new CategoryShowResponse(
            category: $category,
            subcategoryListResponseCollection: $subcategoryListResponseCollection,
            productListResponseCollection: $productListResponseCollection
        );
    }

    private function createSubcategoryListResponse(Category $category): CategorySubcategoryListResponse
    {
        return new CategorySubcategoryListResponse(
            name: $category->getName(),
            href: $this->urlGenerator->generate('shop.category_show', ['slug' => $category->getSlug()]),
            image: $this->fileService->preparePublicPathToFile($category->getFile()?->getPath()),
        );
    }
}
