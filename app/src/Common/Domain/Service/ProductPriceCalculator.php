<?php

declare(strict_types=1);

namespace App\Common\Domain\Service;

use App\Common\Application\Factory\MoneyFactory;
use App\Common\Domain\Entity\Product;
use App\Common\Domain\Entity\Promotion;
use App\Common\Domain\Enums\ReductionType;
use App\Common\Domain\ValueObject\MoneyVO;

final readonly class ProductPriceCalculator
{

    public function __construct(
        private MoneyFactory $moneyFactory
    ) {

    }

    public function calculate(Product $product, ?Promotion $promotion = null): MoneyVO
    {
        $unitPrice = $this->moneyFactory->create($product->getRegularPrice());

        if (null === $promotion) {
            return $unitPrice;
        }

        $reduction = $promotion->getReduction();
        if ($promotion->getType() === ReductionType::PERCENT) {
            return $unitPrice->subtractPercentage($reduction);
        }

        return $unitPrice->subtract($reduction);
    }
}
