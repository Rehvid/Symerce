<?php

declare(strict_types=1);

namespace App\Product\Application\Service;

use App\Common\Application\Factory\MoneyFactory;
use App\Common\Domain\Entity\Product;
use App\Common\Domain\Entity\Promotion;
use App\Common\Domain\Enums\ReductionType;
use App\Common\Domain\ValueObject\MoneyVO;

readonly class ProductPromotionCalculator
{
    public function __construct(
        private MoneyFactory $moneyFactory
    ) {}

    public function calculateDiscountedPrice(Product $product): ?MoneyVO
    {
        if (!$product->hasActivePromotion()) {
            return null;
        }

        $discountedPrice = $this->moneyFactory->create($product->getRegularPrice());

        foreach ($product->getActiveNowPromotions() as $promotion) {
            $discountedPrice = $this->applyReduction($discountedPrice, $promotion);
        }

        return $discountedPrice;
    }

    public function applyReduction(MoneyVO $price, Promotion $promotion): MoneyVO
    {
        return match ($promotion->getType()) {
            ReductionType::AMOUNT => $price->subtract($promotion->getReduction()),
            ReductionType::PERCENT => $price->subtractPercentage($promotion->getReduction()),
        };
    }

}
