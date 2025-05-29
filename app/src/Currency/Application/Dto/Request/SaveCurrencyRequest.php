<?php

declare(strict_types=1);

namespace App\Currency\Application\Dto\Request;

use App\Shared\Application\DTO\Request\RequestDtoInterface;
use App\Shared\Domain\Enums\DecimalPrecision;
use Symfony\Component\Validator\Constraints as Assert;

final readonly class SaveCurrencyRequest
{
    #[Assert\NotBlank]
    #[Assert\Length(min: 3, max: 50)]
    public string $name;

    #[Assert\NotBlank]
    #[Assert\Length(min: 1, max: 3)]
    public string $code;

    #[Assert\NotBlank]
    #[Assert\Length(max: 10)]
    public string $symbol;

    #[Assert\NotBlank]
    #[Assert\Type('numeric')]
    #[Assert\Range(min:0, max: DecimalPrecision::MAXIMUM_SCALE->value)]
    public string|int|null $roundingPrecision;

    public function __construct(
        string $name,
        string $code,
        string $symbol,
        string|int|null $roundingPrecision = null,
    ) {
        $this->name = $name;
        $this->code = $code;
        $this->symbol = $symbol;
        $this->roundingPrecision = $roundingPrecision;
    }
}
