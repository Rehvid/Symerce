<?php

declare(strict_types=1);

namespace App\Product\Application\Hydrator;

use App\Common\Application\Factory\MoneyFactory;
use App\Common\Domain\Entity\Product;
use App\Common\Domain\Entity\ProductPriceHistory;
use App\Common\Domain\Entity\Promotion;
use App\Common\Domain\Enums\ReductionType;
use App\Setting\Domain\Enums\SettingKey;
use App\Setting\Domain\Enums\SettingValueType;
use App\Setting\Domain\Repository\SettingRepositoryInterface;
use App\Setting\Domain\ValueObject\SettingValueVO;

final readonly class ProductPriceHydrator
{
    public function __construct(
        private MoneyFactory $moneyFactory,
        private SettingRepositoryInterface $settingRepository,
    ) {
    }

    public function hydrate(Product $product, ?Promotion $promotion = null): void
    {
        if (!$this->useProductPriceHistory()) {
            return;
        }

        $product->addPriceHistory($this->createProductPriceHistory($product, $promotion));
    }

    private function createProductPriceHistory(Product $product, ?Promotion $promotion = null): ProductPriceHistory
    {
        $productPriceHistory = new ProductPriceHistory();
        $productPriceHistory->setProduct($product);
        $productPriceHistory->setBasePrice($product->getRegularPrice());

        if (null !== $promotion) {
            //TODO: Use ProductPromotionCalculator
            $regularPrice = $this->moneyFactory->create($product->getRegularPrice());
            if (ReductionType::AMOUNT === $promotion->getType()) {
                $discountPrice = $regularPrice->subtract($promotion->getReduction());
            } else {
                $discountPrice = $regularPrice->subtractPercentage($promotion->getReduction());
            }

            $productPriceHistory->setDiscountPrice($discountPrice->getAmount());
        }


        return $productPriceHistory;
    }

    private function useProductPriceHistory(): bool
    {
        $setting = $this->settingRepository->findByKey(SettingKey::ENABLE_PRICE_HISTORY);

        if (null === $setting) {
            return false;
        }

        return (new SettingValueVO(SettingValueType::BOOLEAN, $setting->getValue()))->getValue();
    }
}
