<?php

declare(strict_types=1);

namespace App\Shop\UI\Web;

use App\Admin\Infrastructure\Repository\CarrierDoctrineRepository;
use App\Entity\Product;
use App\Entity\ProductImage;
use App\Service\FileService;
use App\Service\SettingManager;
use App\Shared\Domain\Enums\SettingType;
use App\Shared\Domain\ValueObject\Money;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

class ProductController extends AbstractShopController
{
    public function __construct(
        private readonly SettingManager            $settingManager,
        private readonly FileService               $fileService,
        private readonly CarrierDoctrineRepository $carrierRepository,
        TranslatorInterface                        $translator
    ) {
        parent::__construct($translator);
    }

    #[Route('/kategoria/{slugCategory}/produkt/{slug}', name: 'shop.product_show', methods: ['GET'])]
    public function show(
        #[MapEntity(mapping: ['slug' => 'slug'])] Product $product
    ): Response
    {
        $this->ensurePageIsActive($product);

        $currency = $this->settingManager->findDefaultCurrency();

        $discountPrice = $product->getDiscountPrice() === null ? null : (new Money($product->getDiscountPrice(), $currency))->getFormattedAmountWithSymbol();
        $hasPromotion = $discountPrice !== null;

        $attributes = [];

        foreach ($product->getAttributeValues() as $attributeValue) {
            $attribute = $attributeValue->getAttribute();
            $attributes[$attribute->getName()][] =  $attributeValue->getValue();
        }

        $productRefund = $this->settingManager->get(SettingType::PRODUCT_REFUND)?->getValue();
        $deliveryFeeData = $this->carrierRepository->findLowestAndHighestFee();

        $minFee = isset($deliveryFeeData['minFee']) ? (new Money((string) $deliveryFeeData['minFee'], $currency))->getFormattedAmountWithSymbol() : null;
        $maxFee = isset($deliveryFeeData['maxFee']) ? (new Money((string) $deliveryFeeData['maxFee'], $currency))->getFormattedAmountWithSymbol(): null;

        $deliveryFee = match (true) {
            $minFee !== null && $maxFee !== null => "od $minFee do $maxFee",
            $minFee !== null => $minFee,
            $maxFee !== null => $maxFee,
            default => null,
        };



        //TODO: Make responser and DTO
        $data = [
            'id' => $product->getId(),
            'name' => $product->getName(),
            'tags' => $product->getTags(),
            'vendor' => $product->getVendor(),
            'description' => $product->getDescription(),
            'regularPrice' => (new Money($product->getRegularPrice(), $currency))->getFormattedAmountWithSymbol(),
            'discountPrice' => $discountPrice,
            'hasPromotion' => $hasPromotion,
            'attributes' => $attributes,
            'thumbnail' => $this->fileService->preparePublicPathToFile($product->getThumbnailImage()?->getFile()?->getPath()),
            'images' => $product->getImages()->map(fn (ProductImage $image) => $this->fileService->preparePublicPathToFile($image->getFile()->getPath())),
            'quantity' => $product->getQuantity(),
            'isOutOfStock' => $product->getQuantity() === 0,
            'deliveryTime' => $product->getDeliveryTime()->getLabel(),
            'refund' => null === $productRefund ? 14 : (int) $productRefund,
            'deliveryFee' => $deliveryFee,
        ];

        return $this->render('shop/product/show.html.twig', [
            'product' => $data,
        ]);
    }
}
