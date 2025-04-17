<?php

declare(strict_types=1);

namespace App\DTO\Request\Carrier;

use App\DTO\Request\PersistableInterface;
use App\Traits\FileRequestMapperTrait;
use Symfony\Component\Validator\Constraints as Assert;
use App\Validator\CurrencyPrecision as CustomAssertCurrencyPrecision;

final class SaveCarrierRequestDTO implements PersistableInterface
{
    use FileRequestMapperTrait;

    /**
     * @param array<string, mixed> $image
     *
     * @throws \ReflectionException
     */
    public function __construct(
        #[Assert\NotBlank] #[Assert\Length(min: 2)] public readonly string $name,
        #[Assert\GreaterThanOrEqual(0)] #[Assert\Type('numeric')] #[CustomAssertCurrencyPrecision] public readonly string $fee,
        public readonly bool $isActive,
        public array $image = []
    ) {
        $this->image = $this->createFileRequestDTOs($this->image);
    }
}
