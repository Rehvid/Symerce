<?php

declare(strict_types=1);

namespace App\Carrier\Application\Dto\Request;

use App\Common\Application\Contracts\ArrayHydratableInterface;
use App\Common\Application\Dto\FileData;
use App\Common\Infrastructure\Validator\CurrencyPrecision as CustomAssertCurrencyPrecision;
use Symfony\Component\Validator\Constraints as Assert;

final readonly class SaveCarrierRequest implements ArrayHydratableInterface
{
    #[Assert\NotBlank]
    #[Assert\Length(min: 2, max: 255)]
    public string $name;

    #[Assert\GreaterThanOrEqual(0)]
    #[Assert\Type('numeric')]
    #[CustomAssertCurrencyPrecision]
    public string $fee;

    #[Assert\NotBlank]
    public bool $isActive;

    #[Assert\NotBlank]
    public bool $isExternal;

    /** @var array<int, mixed>  */
    public ?array $externalData;

    public ?FileData $fileData;

    public function __construct(
        string $name,
        string $fee,
        bool $isActive,
        bool $isExternal,
        ?array $externalData,
        ?FileData $fileData = null,
    ) {
        $this->name = $name;
        $this->fee = $fee;
        $this->isActive = $isActive;
        $this->isExternal = $isExternal;
        $this->externalData = $externalData;
        $this->fileData = $fileData;
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
