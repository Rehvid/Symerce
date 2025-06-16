<?php

declare(strict_types=1);

namespace App\Product\Application\Dto\Request;
use App\Common\Domain\Enums\PromotionSource;
use App\Common\Domain\Enums\ReductionType;
use App\Common\Domain\ValueObject\DateVO;
use App\Common\Infrastructure\Utils\BoolHelper;
use Symfony\Component\Validator\Constraints as Assert;

final readonly class SaveProductPromotionRequest
{

    public bool $isActive;

    #[Assert\NotBlank]
    #[Assert\Choice(callback: [ReductionType::class, 'values'])]
    public string $reductionType;

    #[Assert\GreaterThanOrEqual(0)]
    #[Assert\Type('numeric')]
    public string $reduction;

    #[Assert\NotBlank]
    #[Assert\Length(min: 10)]
    public DateVO $startDate;

    #[Assert\NotBlank]
    #[Assert\Length(min: 10)]
    public DateVO $endDate;

    #[Assert\NotBlank]
    #[Assert\Choice(callback: [PromotionSource::class, 'values'])]
    public string $source;

    public function __construct(
        mixed $isActive,
        ?string $reductionType,
        ?string $reduction,
        DateVO $startDate,
        DateVO $endDate,
        ?string $source,
    ) {
        $this->isActive = BoolHelper::castOrFail($isActive, 'isActive');
        $this->reductionType = (string) $reductionType;
        $this->reduction = (string) $reduction;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
        $this->source = (string) $source;
    }
}
