<?php

declare(strict_types=1);

namespace App\Product\Application\Hydrator;

use App\Common\Application\Factory\MoneyFactory;
use App\Common\Application\Hydrator\PromotionHydrator;
use App\Common\Domain\Entity\Product;
use App\Common\Domain\Entity\ProductStock;
use App\Product\Application\Dto\ProductData;
use App\Product\Application\Dto\ProductDataStock;
use App\Product\Application\Dto\ProductPromotionData;

final readonly class ProductHydrator
{
    public function __construct(
        private MoneyFactory             $moneyFactory,
        private PromotionHydrator        $promotionHydrator,
        private ProductStockHydrator     $productStockHydrator,
        private ProductCategoryHydrator  $productCategoryHydrator,
        private ProductTagHydrator       $productTagHydrator,
        private ProductImageHydrator     $productImageHydrator,
        private ProductPriceHydrator     $productPriceHydrator,
        private ProductAttributeHydrator $productAttributeHydrator,
    ) {
    }

    public function hydrate(ProductData $data, Product $product): Product
    {
        if ($product->getId() === null) {
            $regularPriceChanged = true;
        } else {
            $currentProductPrice = $this->moneyFactory->create($product->getRegularPrice());
            $requestProductPrice = $this->moneyFactory->create($data->regularPrice);
            $regularPriceChanged = !$currentProductPrice->equal($requestProductPrice);
        }

        $product->setBrand($data->brand);
        $product->setName($data->name);
        $product->setActive($data->isActive);
        $product->setDescription($data->description);
        $product->setRegularPrice($data->regularPrice);
        $product->setMainCategory($data->mainCategory);
        $product->setMetaDescription($data->metaDescription);
        $product->setMetaTitle($data->metaTitle);

        if ($data->promotionData === null && $regularPriceChanged) {
            $this->productPriceHydrator->hydrate($product);
        }

        $this->productCategoryHydrator->hydrate($data->categories, $product);
        $this->productTagHydrator->hydrate($data->tags, $product);
        $this->productAttributeHydrator->hydrate($data->attributes, $product);
        $this->productImageHydrator->hydrate($data->images, $product);

        $this->handlePromotion($data->promotionData, $product, $regularPriceChanged);
        $this->addProductStock($data->stocks, $product);

        return $product;
    }


    private function handlePromotion(?ProductPromotionData $data, Product $product, bool $regularPriceChanged): void
    {
        $existingPromotion = $product->getPromotionForProductTab();

        $hasPromotion = $existingPromotion !== null;
        $shouldRemove = $data === null && $hasPromotion;

        if ($shouldRemove) {
            $product->removePromotion($existingPromotion);
            return;
        }

        if ($data !== null) {
            $this->savePromotion($data, $product, $regularPriceChanged);
            return;
        }

        if ($regularPriceChanged && $hasPromotion) {
            $this->productPriceHydrator->hydrate($product, $existingPromotion);
        }
    }

    private function savePromotion(ProductPromotionData $data, Product $product, bool $regularPriceChanged): void
    {
        $promotionProduct = $product->getPromotionForProductTab();
        if (null === $promotionProduct) {
            $promotion = $this->promotionHydrator->hydrate($data, $promotionProduct);
            $promotion->setProduct($product);

            $product->addPromotion($promotion);
            $this->productPriceHydrator->hydrate($product, $promotion);
            return;
        }

        $currentReduction = $this->moneyFactory->create($promotionProduct->getReduction());
        $incomingReduction = $this->moneyFactory->create($data->reduction);

        $typeChanged = $promotionProduct->getType()->value !== $data->reductionType;
        $valueChanged = !$currentReduction->equal($incomingReduction);

        $this->promotionHydrator->hydrate($data, $promotionProduct);

        if ($typeChanged || $valueChanged || $regularPriceChanged) {
            $this->productPriceHydrator->hydrate($product, $promotionProduct);
        }
    }

    /** @param ProductDataStock[] $dataStocks */
    private function addProductStock(array $dataStocks, Product $product): void
    {
        $product->getProductStocks()->clear();

        foreach ($dataStocks as $dataStock) {
            $product->addStock(
                $this->productStockHydrator->hydrate($dataStock, $product, new ProductStock())
            );
        }
    }
}
