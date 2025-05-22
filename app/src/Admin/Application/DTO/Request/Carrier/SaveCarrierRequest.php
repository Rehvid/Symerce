<?php

declare(strict_types=1);

namespace App\Admin\Application\DTO\Request\Carrier;

use App\Admin\Domain\Model\FileData;
use App\Shared\Application\Contract\ArrayHydratableInterface;
use App\Shared\Application\DTO\Request\RequestDtoInterface;
use App\Shared\Infrastructure\Validator\CurrencyPrecision as CustomAssertCurrencyPrecision;
use Symfony\Component\Validator\Constraints as Assert;

final readonly class SaveCarrierRequest implements ArrayHydratableInterface, RequestDtoInterface
{
    public function __construct(
        #[Assert\NotBlank] #[Assert\Length(min: 2)] public string $name,
        #[Assert\GreaterThanOrEqual(0)] #[Assert\Type('numeric')] #[CustomAssertCurrencyPrecision] public string $fee,
        public bool $isActive,
        public ?FileData $fileData = null,
    ) {
    }

    public static function fromArray(array $data): ArrayHydratableInterface
    {
        $image = $data['image'] ?? null;
        $fileData = null;
        if (!empty($image)) {
            $fileData = FileData::fromArray($image[0]);
        }

        return new self(
            name: $data['name'],
            fee: $data['fee'],
            isActive: $data['isActive'],
            fileData: $fileData,
        );
    }
}
