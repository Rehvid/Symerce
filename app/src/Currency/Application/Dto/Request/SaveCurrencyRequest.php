<?php

declare(strict_types=1);

namespace App\Currency\Application\Dto\Request;

use App\Common\Application\Dto\Request\IdRequest;
use App\Common\Domain\Entity\Currency;
use App\Common\Domain\Enums\DecimalPrecision;
use App\Common\Infrastructure\Validator\UniqueEntityField as CustomAssertUniqueField;
use Symfony\Component\Validator\Constraints as Assert;

final readonly class SaveCurrencyRequest
{
    #[Assert\Valid]
    public IdRequest $idRequest;

    #[Assert\NotBlank]
    #[Assert\Length(min: 3, max: 255)]
    #[CustomAssertUniqueField(options: ['field' => 'name', 'className' => Currency::class])]
    public string $name;

    #[Assert\NotBlank]
    #[Assert\Length(min: 3, max: 3)]
    #[CustomAssertUniqueField(options: ['field' => 'code', 'className' => Currency::class])]
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
        string|int|null $id,
        string|int|null $roundingPrecision = null,
    ) {
        $this->name = $name;
        $this->code = $code;
        $this->symbol = $symbol;
        $this->roundingPrecision = $roundingPrecision;
        $this->idRequest = new IdRequest($id);
    }
}
