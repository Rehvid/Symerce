<?php

declare(strict_types=1);

namespace App\Product\Application\Dto;

use App\Admin\Domain\Enums\PromotionSource;
use App\Admin\Domain\Enums\ReductionType;
use App\Admin\Domain\ValueObject\DateVO;

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
