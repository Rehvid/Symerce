<?php

declare(strict_types=1);

namespace App\Admin\Application\DTO\Request\DeliveryTime;

use App\Enums\DeliveryType;
use App\Shared\Application\DTO\Request\RequestDtoInterface;
use Symfony\Component\Validator\Constraints as Assert;

final readonly class SaveDeliveryTimeRequest implements RequestDtoInterface
{
    public function __construct(
        #[Assert\NotBlank] public string $label,
        #[Assert\NotBlank] #[Assert\Type('numeric')]  #[Assert\GreaterThanOrEqual(0)] public string|int $minDays,
        #[Assert\NotBlank] #[Assert\Type('numeric')] #[Assert\GreaterThanOrEqual(propertyPath: 'minDays')] public string|int $maxDays,
        #[Assert\NotBlank] #[Assert\Choice(callback: [DeliveryType::class, 'values'])] public string $type,
        public bool $isActive,
    ) {
    }
}
