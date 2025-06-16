<?php

declare(strict_types=1);

namespace App\Product\Application\Factory;

use App\Brand\Domain\Repository\BrandRepositoryInterface;
use App\Category\Domain\Repository\CategoryRepositoryInterface;
use App\Common\Domain\Entity\Brand;
use App\Common\Domain\Entity\Category;
use App\Common\Domain\Entity\Tag;
use App\Common\Domain\Enums\PromotionSource;
use App\Common\Domain\Enums\ReductionType;
use App\Common\Domain\Exception\EntityNotFoundException;
use App\Product\Application\Dto\ProductData;
use App\Product\Application\Dto\ProductPromotionData;
use App\Product\Application\Dto\Request\SaveProductPromotionRequest;
use App\Product\Application\Dto\Request\SaveProductRequest;
use App\Tag\Domain\Repository\TagRepositoryInterface;

final readonly class ProductDataFactory
{
    public function __construct(
        private ProductAttributeDataFactory $productAttributeDataFactory,
        private ProductImageDataFactory $productImageDataFactory,
        private ProductDataStockFactory $productDataStockFactory,
        private TagRepositoryInterface $tagRepository,
        private CategoryRepositoryInterface $categoryRepository,
        private BrandRepositoryInterface $brandRepository,
    ) {
    }

    public function createFromRequest(SaveProductRequest $request): ProductData
    {
        /** @var Category[] $categories */
        $categories = $this->categoryRepository->findBy(['id' => $request->categories]);

        /** @var Tag[] $tags */
        $tags = $this->tagRepository->findBy(['id' => $request->tags]);


        return new ProductData(
            name: $request->name,
            slug: $request->slug,
            description: $request->description,
            metaTitle: $request->metaTitle,
            metaDescription: $request->metaDescription,
            regularPrice: $request->regularPrice,
            isActive: $request->isActive,
            mainCategory: $this->findMainCategory($request->mainCategoryIdRequest->getId(), $categories),
            brand: $this->findBrand($request->brandIdRequest->getId()),
            promotionData: $request->productPromotionRequest ? $this->createProductPromotionData($request->productPromotionRequest) : null,
            stocks: $this->productDataStockFactory->createFromArray($request->stocks),
            images: $this->productImageDataFactory->createFromArray($request->images),
            attributes: $this->productAttributeDataFactory->createFromArray($request->attributes),
            tags: $tags,
            categories: $categories,
        );
    }

    private function findMainCategory(?int $mainCategoryId, array $categories): Category
    {
        $entityCategories = [];
        foreach ($categories as $category) {
            $entityCategories[$category->getId()] = $category;
        }

        $mainCategory = $entityCategories[$mainCategoryId] ?? null;
        if (null === $mainCategory) {
            throw EntityNotFoundException::for(Category::class, $mainCategoryId);
        }

        return $mainCategory;
    }

    private function findBrand(?int $brandId): Brand
    {
        /** @var ?Brand $entityBrand */
        $entityBrand = $this->brandRepository->findById($brandId);
        if (null === $entityBrand) {
            throw EntityNotFoundException::for(Brand::class, $brandId);
        }

        return $entityBrand;
    }

    private function createProductPromotionData(SaveProductPromotionRequest $request): ProductPromotionData
    {
        return new ProductPromotionData(
            isActive: $request->isActive,
            reductionType: ReductionType::from($request->reductionType),
            promotionSource: PromotionSource::from($request->source),
            reduction: $request->reduction,
            startDate: $request->startDate,
            endDate: $request->endDate,
        );
    }
}
