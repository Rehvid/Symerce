<?php

declare(strict_types=1);

namespace App\Controller\Shop;

use App\Entity\AttributeValue;
use App\Entity\Product;
use App\Entity\ProductImage;
use App\Enums\SettingType;
use App\Repository\CarrierRepository;
use App\Service\FileService;
use App\Service\SettingManager;
use App\ValueObject\Money;
use Symfony\Bridge\Doctrine\Attribute\MapEntity;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

class ProductController extends AbstractController
{
    public function __construct(
        private readonly SettingManager $settingManager,
        private readonly FileService $fileService,
        private readonly CarrierRepository $carrierRepository,
    ) {
    }

    #[Route('/kategoria/{slugCategory}/produkt/{slug}', name: 'shop.product_show', methods: ['GET'])]
    public function show(
        #[MapEntity(mapping: ['slug' => 'slug'])] Product $product
    ): Response
    {
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
