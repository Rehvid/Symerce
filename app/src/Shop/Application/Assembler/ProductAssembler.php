<?php

declare(strict_types=1);

namespace App\Shop\Application\Assembler;

use App\Admin\Application\Service\FileService;
use App\Admin\Domain\Entity\Product;
use App\Admin\Domain\Entity\ProductImage;
use App\Admin\Domain\Repository\CarrierRepositoryInterface;
use App\Setting\Domain\Enums\SettingKey;
use App\Setting\Domain\Enums\SettingType;
use App\Shared\Application\Factory\MoneyFactory;
use App\Shared\Application\Service\SettingsService;
use App\Shop\Application\DTO\Response\Product\ProductShowResponse;

final readonly class ProductAssembler
{
    public function __construct(
        private CarrierRepositoryInterface $carrierRepository,
        private MoneyFactory $moneyFactory,
        private SettingsService $settingsService,
        private FileService $fileService,
    ) {

    }

    public function toShowResponse(Product $product): array
    {
        $data = null;

//        $discountPrice = $product->getDiscountPrice() === null ? null : (new Money($product->getDiscountPrice(), $currency))->getFormattedAmountWithSymbol();
//        $hasPromotion = $discountPrice !== null;
//
//        $attributes = [];
//
//        foreach ($product->getAttributeValues() as $attributeValue) {
//            $attribute = $attributeValue->getAttribute();
//            $attributes[$attribute->getName()][] =  $attributeValue->getValue();
//        }
//
//        $productRefund = $this->settingManager->get(SettingType::PRODUCT_REFUND)?->getValue();
//        $deliveryFeeData = $this->carrierRepository->findLowestAndHighestFee();
//
//        $minFee = isset($deliveryFeeData['minFee']) ? (new Money((string) $deliveryFeeData['minFee'], $currency))->getFormattedAmountWithSymbol() : null;
//        $maxFee = isset($deliveryFeeData['maxFee']) ? (new Money((string) $deliveryFeeData['maxFee'], $currency))->getFormattedAmountWithSymbol(): null;
//
//        $deliveryFee = match (true) {
//            $minFee !== null && $maxFee !== null => "od $minFee do $maxFee",
//            $minFee !== null => $minFee,
//            $maxFee !== null => $maxFee,
//            default => null,
//        };
//
//
//
//        //TODO: Make responser and DTO
//        $data = [
//            'id' => $product->getId(),
//            'name' => $product->getName(),
//            'tags' => $product->getTags(),
//            'vendor' => $product->getVendor(),
//            'description' => $product->getDescription(),
//            'regularPrice' => (new Money($product->getRegularPrice(), $currency))->getFormattedAmountWithSymbol(),
//            'discountPrice' => $discountPrice,
//            'hasPromotion' => $hasPromotion,
//            'attributes' => $attributes,
//            'thumbnail' => $this->fileService->preparePublicPathToFile($product->getThumbnailImage()?->getFile()?->getPath()),
//            'images' => $product->getImages()->map(fn (ProductImage $image) => $this->fileService->preparePublicPathToFile($image->getFile()->getPath())),
//            'quantity' => $product->getQuantity(),
//            'isOutOfStock' => $product->getQuantity() === 0,
//            'deliveryTime' => $product->getDeliveryTime()->getLabel(),
//            'refund' => null === $productRefund ? 14 : (int) $productRefund,
//            'deliveryFee' => $deliveryFee,
//        ];


        return [
            'product' => $this->createProductShowResponse($product),
        ];
    }

    public function createProductShowResponse(Product $product): ProductShowResponse
    {
        $discountPrice = $product->getDiscountPrice() === null
            ? null
            : ($this->moneyFactory->create($product->getDiscountPrice()))->getFormattedAmountWithSymbol();
        $hasPromotion = $discountPrice !== null;
        $quantity = $product->getQuantity();

        $productRefund = $this->settingsService->getByKey(SettingKey::PRODUCT_REFUND_POLICY)?->getValue();

        return new ProductShowResponse(
            id: $product->getId(),
            name: $product->getName(),
            vendor: $product->getVendor(),
            description: $product->getDescription(),
            regularPrice: ($this->moneyFactory->create($product->getRegularPrice()))->getFormattedAmountWithSymbol(),
            discountPrice: $discountPrice,
            quantity: $quantity,
            isOutOfStock: $quantity === 0,
            hasPromotion: $hasPromotion,
            refund: null === $productRefund ? 14 : (int) $productRefund,
            deliveryTime: $product->getDeliveryTime()->getLabel(),
            deliveryFee: $this->getDeliveryFee(),
            attributes: $this->getAttributes($product),
            tags: $product->getTags()->toArray(),
            thumbnail: $this->fileService->preparePublicPathToFile($product->getThumbnailImage()?->getFile()?->getPath()),
            images: $product->getImages()->map(fn (ProductImage $image) => $this->fileService->preparePublicPathToFile($image->getFile()->getPath())),
        );
    }

    private function getDeliveryFee(): string
    {
        $deliveryFeeData = $this->carrierRepository->findLowestAndHighestFee();

        $minFee = isset($deliveryFeeData['minFee'])
            ? ($this->moneyFactory->create((string) $deliveryFeeData['minFee']))->getFormattedAmountWithSymbol()
            : null;
        $maxFee = isset($deliveryFeeData['maxFee'])
            ? ($this->moneyFactory->create((string) $deliveryFeeData['maxFee']))->getFormattedAmountWithSymbol()
            : null;

        return match (true) {
            $minFee !== null && $maxFee !== null => "od $minFee do $maxFee",
            $minFee !== null => $minFee,
            $maxFee !== null => $maxFee,
            default => null,
        };
    }

    private function getAttributes(Product $product): array
    {
        $attributes = [];

        foreach ($product->getAttributeValues() as $attributeValue) {
            $attribute = $attributeValue->getAttribute();
            $attributes[$attribute->getName()][] =  $attributeValue->getValue();
        }

        return $attributes;
    }
}
