<?php

declare(strict_types=1);

namespace App\Shared\Domain\Service;

use App\Admin\Domain\Enums\ReductionType;
use App\Common\Domain\Entity\Product;
use App\Common\Domain\Entity\Promotion;
use App\Shared\Application\Factory\MoneyFactory;
use App\Shared\Domain\ValueObject\Money;

final readonly class ProductPriceCalculator
{

    public function __construct(
        private MoneyFactory $moneyFactory
    ) {

    }

    public function calculate(Product $product, ?Promotion $promotion = null): Money
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
