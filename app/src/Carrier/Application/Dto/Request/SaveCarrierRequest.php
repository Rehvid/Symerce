<?php

declare(strict_types=1);

namespace App\Carrier\Application\Dto\Request;

use App\Common\Application\Contracts\ArrayHydratableInterface;
use App\Common\Application\Dto\FileData;
use App\Common\Application\Dto\Request\RequestDtoInterface;
use App\Common\Infrastructure\Validator\CurrencyPrecision as CustomAssertCurrencyPrecision;
use Symfony\Component\Validator\Constraints as Assert;

final readonly class SaveCarrierRequest implements ArrayHydratableInterface, RequestDtoInterface
{
    public function __construct(
        #[Assert\NotBlank] #[Assert\Length(min: 2)] public string $name,
        #[Assert\GreaterThanOrEqual(0)] #[Assert\Type('numeric')] #[CustomAssertCurrencyPrecision] public string $fee,
        public bool $isActive,
        public bool $isExternal,
        public ?array $externalData,
        public ?FileData $fileData = null,
    ) {
    }

    public static function fromArray(array $data): ArrayHydratableInterface
    {
        $thumbnail = $data['thumbnail'] ?? null;
        $fileData = null;
        if (!empty($thumbnail)) {
            $fileData = FileData::fromArray($thumbnail[0]);
        }

        return new self(
            name: $data['name'],
            fee: $data['fee'],
            isActive: $data['isActive'],
            isExternal: $data['isExternal'] ?? false,
            externalData: $data['externalData'] ?? null,
            fileData: $fileData,
        );
    }
}
