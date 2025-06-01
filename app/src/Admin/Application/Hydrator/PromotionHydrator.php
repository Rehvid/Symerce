<?php

declare(strict_types=1);

namespace App\Admin\Application\Hydrator;

use App\Admin\Application\DTO\Request\Product\SaveProductPromotionRequest;
use App\Admin\Domain\Enums\PromotionSource;
use App\Admin\Domain\Enums\ReductionType;
use App\Common\Domain\Entity\Promotion;

final readonly class PromotionHydrator
{
    public function hydrate(SaveProductPromotionRequest $promotionRequest, ?Promotion $promotion = null): Promotion
    {
        $promotion = $promotion ?? new Promotion();
        $promotion->setType(ReductionType::tryFrom($promotionRequest->reductionType));
        $promotion->setReduction($promotionRequest->reduction);
        $promotion->setActive($promotionRequest->isActive);
        $promotion->setStartsAt($promotionRequest->startDate->get());
        $promotion->setEndsAt($promotionRequest->endDate->get());
        $promotion->setSource(PromotionSource::tryFrom($promotionRequest->source));

        return $promotion;
    }
}
