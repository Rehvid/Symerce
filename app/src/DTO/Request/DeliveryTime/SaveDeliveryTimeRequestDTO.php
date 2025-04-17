<?php

declare(strict_types=1);

namespace App\DTO\Request\DeliveryTime;

use App\DTO\Request\PersistableInterface;
use App\Enums\DeliveryType;
use Symfony\Component\Validator\Constraints as Assert;

final class SaveDeliveryTimeRequestDTO implements PersistableInterface
{
    public function __construct(
        #[Assert\NotBlank] public string $label,
        #[Assert\NotBlank] #[Assert\Type('digit')]  #[Assert\GreaterThanOrEqual(0)] public string $minDays,
        #[Assert\NotBlank] #[Assert\Type('digit')] #[Assert\GreaterThanOrEqual(propertyPath: 'minDays')] public string $maxDays,
        #[Assert\NotBlank] #[Assert\Choice(callback: [DeliveryType::class, 'values'])] public string $type
    ) {
    }
}
