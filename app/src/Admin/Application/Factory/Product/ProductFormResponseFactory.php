<?php

declare(strict_types=1);

namespace App\Admin\Application\Factory\Product;

use App\Admin\Application\DTO\Response\Product\ProductFormResponse;
use App\Admin\Application\DTO\Response\Product\ProductImageResponse;
use App\Admin\Application\Service\FileService;
use App\Admin\Domain\Entity\AttributeValue;
use App\Admin\Domain\Entity\Category;
use App\Admin\Domain\Entity\Product;
use App\Admin\Domain\Entity\ProductImage;
use App\Admin\Domain\Entity\Tag;
use App\Shared\Application\Factory\MoneyFactory;

final readonly class ProductFormResponseFactory
{
    public function __construct(
        private MoneyFactory $moneyFactory,
        private FileService $fileService,
    ) {}

    public function fromProduct(Product $product): ProductFormResponse
    {
        $promotion = $product->getPromotions()->first();
        $stock = $product->getStock();

        return new ProductFormResponse(
            name: $product->getName(),
            slug: $product->getSlug(),
            description: $product->getDescription(),
            regularPrice: $this->moneyFactory->create($product->getRegularPrice())->getFormattedAmount(),
            quantity: $product->getQuantity(),
            isActive: $product->isActive(),
            deliveryTime: (string) $product->getDeliveryTime()?->getId(),
            vendor: (string) $product->getVendor()?->getId(),
            mainCategory: $product->getMainCategory()?->getId(),
            tags: $product->getTags()->map(fn (Tag $tag) => (string) $tag->getId())->toArray(),
            categories: $product->getCategories()->map(fn (Category $category) => $category->getId())->toArray(),
            attributes: $this->getAttributesForFormDataResponse($product),
            images: $product->getImages()->map(
                fn (ProductImage $productImage) => $this->createProductImageResponse($productImage)
            )->toArray(),
            promotionIsActive: $promotion && $promotion->isActive(),
            promotionReduction: $promotion ? $promotion->getReduction() : null,
            promotionReductionType: $promotion ? $promotion->getType()->value : null,
            promotionDateRange: $promotion ? [$promotion->getStartsAt(), $promotion->getEndsAt()] : [],
            stockAvailableQuantity: $stock->getAvailableQuantity(),
            stockLowStockThreshold: $stock->getLowStockThreshold(),
            stockMaximumStockLevel: $stock->getMaximumStockLevel(),
            stockNotifyOnLowStock: $stock->isNotifyOnLowStock(),
            stockVisibleInStore: $stock->isVisibleInStore(),
            stockSku: $stock->getSku(),
            stockEan13: $stock->getEan13(),
        );
    }

    private function createProductImageResponse(ProductImage $productImage): ProductImageResponse
    {
        $file = $productImage->getFile();

        return new ProductImageResponse(
            id: $file->getId(),
            name: $file->getName(),
            preview: $this->fileService->preparePublicPathToFile($file->getPath()),
            isThumbnail: $productImage->isThumbnail(),
        );
    }

    private function getAttributesForFormDataResponse(Product $product): array
    {
        $productAttributes = [];
        $product->getAttributeValues()->map(function (AttributeValue $attributeValue) use (&$productAttributes) {
            $attributeId = $attributeValue->getAttribute()->getId();
            $index = 'attribute_'.$attributeId;

            $productAttributes[$index][] = (string) $attributeValue->getId();

            return $productAttributes;
        })->toArray();

        return $productAttributes;
    }
}
