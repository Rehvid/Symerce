<?php

declare(strict_types=1);

namespace App\Common\Application\Hydrator;

use App\Common\Domain\Entity\Promotion;
use App\Common\Domain\Enums\ReductionType;
use App\Product\Application\Dto\ProductPromotionData;

final readonly class PromotionHydrator
{
    public function hydrate(ProductPromotionData $data, Promotion $promotion): Promotion
    {
        $promotion->setType($data->reductionType ?? ReductionType::AMOUNT);
        $promotion->setReduction($data->reduction);
        $promotion->setActive($data->isActive);
        $promotion->setStartsAt($data->startDate->get());
        $promotion->setEndsAt($data->endDate->get());
        $promotion->setSource($data->promotionSource);

        return $promotion;
    }
}
