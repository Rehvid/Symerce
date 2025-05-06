<?php

declare(strict_types=1);

namespace App\DTO\Admin\Request\Currency;

use App\DTO\Admin\Request\PersistableInterface;
use App\Enums\DecimalPrecision;
use Symfony\Component\Validator\Constraints as Assert;

readonly class SaveCurrencyRequestDTO implements PersistableInterface
{
    public function __construct(
        #[Assert\NotBlank] #[Assert\Length(min: 3, max: 50)] public string $name,
        #[Assert\NotBlank] #[Assert\Length(min: 1, max: 3)] public string $code,
        #[Assert\NotBlank] #[Assert\Length(max: 10)] public string $symbol,
        #[Assert\NotBlank] #[Assert\Type('numeric')] #[Assert\Range(min:0, max: DecimalPrecision::MAXIMUM_SCALE->value)] public string|int|null $roundingPrecision = null,
    ) {

    }
}
