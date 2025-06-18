<?php

declare(strict_types=1);

namespace App\Product\Application\Assembler\Shop;

use App\Carrier\Domain\Repository\CarrierRepositoryInterface;
use App\Common\Application\Factory\MoneyFactory;
use App\Common\Application\Service\FileService;
use App\Common\Application\Service\SettingsService;
use App\Common\Domain\Entity\Product;
use App\Common\Domain\Entity\ProductImage;
use App\Product\Application\Dto\Shop\Response\ProductListResponse;
use App\Product\Application\Service\ProductPromotionCalculator;
use App\Setting\Domain\Enums\SettingKey;
use App\Shop\Application\DTO\Response\Product\ProductShowResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

final readonly class ProductAssembler
{
    public function __construct(
        private UrlGeneratorInterface $urlGenerator,
        private MoneyFactory $moneyFactory,
        private ProductPromotionCalculator $productPromotionCalculator,
        private FileService $fileService,
    ) {
    }

    public function toListResponse(Product $product, ?string $slugCategory = null): ProductListResponse
    {
        $url = $this->urlGenerator->generate(
            'shop.product_show',
            [
                'slugCategory' => $slugCategory ?? $product->getMainCategory()->getSlug(),
                'slug' => $product->getSlug()
            ]
        );
        $discountPrice = $this->productPromotionCalculator->calculateDiscountedPrice($product);
        $thumbnail = $this->fileService->preparePublicPathToFile(
            $product->getThumbnailImage()?->getFile()->getPath()
        );

        return new ProductListResponse(
            name: $product->getName(),
            url: $url,
            thumbnail: $thumbnail,
            discountPrice: $discountPrice?->getFormattedAmountWithSymbol(),
            regularPrice: $this->moneyFactory->create($product->getRegularPrice())->getFormattedAmountWithSymbol(),
            hasPromotion: $product->hasActivePromotion(),
        );
    }
}
