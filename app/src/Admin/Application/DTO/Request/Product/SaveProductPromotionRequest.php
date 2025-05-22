<?php

declare(strict_types=1);

namespace App\Admin\Application\DTO\Request\Product;
use App\Admin\Domain\Enums\ReductionType;
use App\Admin\Domain\ValueObject\DateVO;
use Symfony\Component\Validator\Constraints as Assert;

final readonly class SaveProductPromotionRequest
{
    public function __construct(
        public bool $isActive,
        #[Assert\NotBlank] #[Assert\Choice(callback: [ReductionType::class, 'values'])]  public string $reductionType,
        #[Assert\GreaterThanOrEqual(0)] #[Assert\Type('numeric')] public string $reduction,
        #[Assert\NotBlank] #[Assert\Length(min: 10)]  public DateVO $startDate,
        #[Assert\NotBlank] #[Assert\Length(min: 10)]  public DateVO $endDate,
    ) {

    }
}
