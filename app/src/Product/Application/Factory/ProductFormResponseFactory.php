<?php

declare(strict_types=1);

namespace App\Product\Application\Factory;

use App\Common\Application\Dto\OptionItem;
use App\Common\Application\Factory\MoneyFactory;
use App\Common\Application\Service\FileService;
use App\Common\Domain\Entity\Category;
use App\Common\Domain\Entity\Product;
use App\Common\Domain\Entity\ProductAttribute;
use App\Common\Domain\Entity\ProductImage;
use App\Common\Domain\Entity\ProductStock;
use App\Common\Domain\Entity\Tag;
use App\Product\Application\Dto\Response\Form\ProductFormAttributeResponse;
use App\Product\Application\Dto\Response\Form\ProductFormImageResponse;
use App\Product\Application\Dto\Response\Form\ProductFormResponse;
use App\Product\Application\Dto\Response\Form\ProductFormStockResponse;

final readonly class ProductFormResponseFactory
{
    public function __construct(
        private MoneyFactory $moneyFactory,
        private FileService $fileService,
    ) {}

    public function fromProduct(Product $product): ProductFormResponse
    {
        $promotion = $product->getPromotionForProductTab();

        return new ProductFormResponse(
            name: $product->getName(),
            slug: $product->getSlug(),
            metaTitle: $product?->getMetaTitle(),
            metaDescription: $product?->getMetaDescription(),
            description: $product->getDescription(),
            regularPrice: $this->moneyFactory->create($product->getRegularPrice())->getFormattedAmount(),
            isActive: $product->isActive(),
            mainCategory: $product->getMainCategory()?->getId(),
            brand: $this->getBrand($product),
            stocks: $this->getStocks($product),
            tags: $product->getTags()->map(fn (Tag $tag) => $tag->getId())->toArray(),
            categories: $product->getCategories()->map(fn (Category $category) => $category->getId())->toArray(),
            attributes: $this->getAttributesForFormDataResponse($product),
            images: $product->getImages()->map(
                fn (ProductImage $productImage) => $this->createProductImageResponse($productImage)
            )->toArray(),
            promotionIsActive: $promotion && $promotion->isActive(),
            promotionReduction: $promotion?->getReduction(),
            promotionReductionType: $promotion?->getType()->value,
            promotionDateRange: $promotion ? [$promotion->getStartsAt(), $promotion->getEndsAt()] : [],
        );
    }

    private function getBrand(Product $product): ?OptionItem
    {
        return $product->getBrand()
            ? new OptionItem(
                label: $product->getBrand()->getName(),
                value: $product->getBrand()->getId()
            )
            : null;
    }

    private function createProductImageResponse(ProductImage $productImage): ProductFormImageResponse
    {
        $file = $productImage->getFile();

        return new ProductFormImageResponse(
            id: $file->getId(),
            name: $file->getName(),
            preview: $this->fileService->preparePublicPathToFile($file->getPath()),
            isThumbnail: $productImage->isThumbnail(),
        );
    }

    private function getAttributesForFormDataResponse(Product $product): array
    {
        $productAttributes = [];
        /** @var ProductAttribute $attribute */
        foreach ($product->getAttributes() as $attribute) {
            $attributeId = $attribute->getAttribute()->getId();
            $index = 'attribute_'.$attributeId;
            if (null === $attribute->getCustomValue()) {
                $productAttributes[$index][] = new ProductFormAttributeResponse(
                    value: new OptionItem(
                        label: $attribute->getPredefinedValue()?->getValue() ?? '',
                        value: $attribute->getPredefinedValue()?->getId(),
                    ),
                    isCustom:  false
                );
                continue;
            }

            $productAttributes[$index][] = new ProductFormAttributeResponse(
                value: $attribute?->getCustomValue() ?? '',
                isCustom: true
            );
        }

        return $productAttributes;
    }

    /** @return ProductFormStockResponse[]  */
    private function getStocks(Product $product): array
    {
        $stocks = [];

        /** @var ProductStock[] $stock */
        foreach ($product->getProductStocks() as $stock) {
            $stocks[] = new ProductFormStockResponse(
                availableQuantity: $stock->getAvailableQuantity(),
                ean13: $stock->getEan13(),
                sku: $stock->getSku(),
                lowStockThreshold: $stock->getLowStockThreshold() === 0 ? null : $stock->getLowStockThreshold(),
                maximumStockLevel: $stock->getMaximumStockLevel() === 0 ? null : $stock->getMaximumStockLevel(),
                warehouseId: new OptionItem(
                    label: $stock->getWarehouse()->getName(),
                    value: $stock->getWarehouse()->getId()
                ),
                restockDate: $stock->getRestockDate()
            );
        }

        return $stocks;
    }
}
