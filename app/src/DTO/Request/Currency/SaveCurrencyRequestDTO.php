<?php

declare (strict_types = 1);

namespace App\DTO\Request\Currency;

use App\Enums\DecimalPrecision;
use App\Interfaces\PersistableInterface;

use Symfony\Component\Validator\Constraints as Assert;


readonly class SaveCurrencyRequestDTO implements PersistableInterface
{
    public function __construct(
        public string  $name,
        public string  $code,
        public string  $symbol,
       #[Assert\Range(min:0, max: DecimalPrecision::MAXIMUM_SCALE)] public ?string $roundingPrecision = null,
    ) {

    }
}
