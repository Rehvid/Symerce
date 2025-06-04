<?php

declare(strict_types=1);

namespace App\Product\Application\Dto;

use App\Common\Domain\Enums\PromotionSource;
use App\Common\Domain\Enums\ReductionType;
use App\Common\Domain\ValueObject\DateVO;

final readonly class ProductPromotionData
{
    public function __construct(
        public bool $isActive,
        public ?ReductionType $reductionType,
        public ?PromotionSource $promotionSource,
        public string $reduction,
        public DateVO $startDate,
        public DateVO $endDate,
    ) {}
}
