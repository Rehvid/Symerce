<?php

declare(strict_types=1);

namespace App\Shop\Application\Assembler;

use App\Category\Domain\Repository\CategoryRepositoryInterface;
use App\Common\Application\Factory\MoneyFactory;
use App\Common\Application\Service\FileService;
use App\Common\Domain\Entity\Category;
use App\Common\Domain\Entity\Product;
use App\Shop\Application\DTO\Response\Category\CategoryListResponse;
use App\Shop\Application\DTO\Response\Category\CategorySubcategoryListResponse;
use App\Shop\Application\DTO\Response\Product\ProductListResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

final readonly class CategoryAssembler
{
    public function __construct(
        private CategoryRepositoryInterface $categoryRepository,
        private UrlGeneratorInterface $urlGenerator,
        private FileService $fileService,
        private MoneyFactory $moneyFactory,
    ) {}

    public function toListResponse(): array
    {
        $categories = $this->categoryRepository->findBy(['isActive' => true], ['order' => 'ASC']);

        return [
            'categories' => array_map(
                fn (Category $category) => $this->createCategoryListResponse($category), $categories
            )
        ];
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

    public function toShowResponse(Category $category): array
    {
        $subcategories = array_map(
            fn (Category $category) => $this->createSubcategoryListResponse($category),
            $category->getChildren()->toArray()
        );
        $products = array_map(
            fn (Product $product) => $this->createProductListResponse($product, $category->getSlug()),
            $category->getProducts()->toArray()
        );

        return [
            'category' => $category,
            'subcategories' => $subcategories,
            'products' => $products,
        ];
    }

    private function createSubcategoryListResponse(Category $category): CategorySubcategoryListResponse
    {
        return new CategorySubcategoryListResponse(
            name: $category->getName(),
            href: $this->urlGenerator->generate('shop.category_show', ['slug' => $category->getSlug()]),
            image: $this->fileService->preparePublicPathToFile($category->getFile()?->getPath()),
        );
    }

    private function createProductListResponse(Product $product, string $slugCategory): ProductListResponse
    {
        $discountPrice = $product->getDiscountPrice() === null
            ? null
            : ($this->moneyFactory->create($product->getDiscountPrice()))->getFormattedAmountWithSymbol();

        return new ProductListResponse(
          name: $product->getName(),
          url: $this->urlGenerator->generate('shop.product_show', ['slugCategory' => $slugCategory,'slug' => $product->getSlug()]),
          thumbnail: $this->fileService->preparePublicPathToFile($product->getThumbnailImage()?->getFile()),
          discountPrice: $discountPrice,
          regularPrice: ($this->moneyFactory->create($product->getRegularPrice()))->getFormattedAmountWithSymbol(),
          hasPromotion: $discountPrice !== null,
        );
    }
}
