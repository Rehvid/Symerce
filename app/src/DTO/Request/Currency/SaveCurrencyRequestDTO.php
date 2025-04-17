<?php

declare(strict_types=1);

namespace App\DTO\Request\Currency;

use App\DTO\Request\PersistableInterface;
use App\Enums\DecimalPrecision;
use Symfony\Component\Validator\Constraints as Assert;

readonly class SaveCurrencyRequestDTO implements PersistableInterface
{
    public function __construct(
        public string $name,
        public string $code,
        public string $symbol,
        #[Assert\NotBlank] #[Assert\Type('digit')] #[Assert\Range(min:0, max: DecimalPrecision::MAXIMUM_SCALE->value)] public ?string $roundingPrecision = null,
    ) {

    }
}
