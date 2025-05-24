<?php

declare (strict_types = 1);

namespace App\Admin\Application\Hydrator\Product;

use App\Admin\Domain\Entity\Product;
use App\Admin\Domain\Entity\ProductPriceHistory;
use App\Admin\Domain\Entity\Promotion;
use App\Admin\Domain\Enums\ReductionType;
use App\Admin\Domain\Repository\SettingRepositoryInterface;
use App\Shared\Application\Factory\MoneyFactory;
use App\Shared\Domain\Enums\SettingType;


final readonly class ProductPriceHydrator
{
    public function __construct(
        private MoneyFactory $moneyFactory,
        private SettingRepositoryInterface $settingRepository,
    ) {}


    public function hydrate(Product $product, ?Promotion $promotion = null) : void
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

        if ($promotion !== null) {
            $regularPrice = $this->moneyFactory->create($product->getRegularPrice());
            if ($promotion->getType() === ReductionType::AMOUNT) {
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
        $setting = $this->settingRepository->findByType(SettingType::USE_PRODUCT_PRICE_HISTORY);
        if ($setting === null) {
            return false;
        }
        return $setting->getValue() === 'false' ? false : true;
    }

}
