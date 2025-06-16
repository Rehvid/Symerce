<?php

declare(strict_types=1);

namespace App\Carrier\Application\Dto\Request;

use App\Common\Application\Dto\FileData;
use App\Common\Infrastructure\Utils\BoolHelper;
use App\Common\Infrastructure\Validator\CurrencyPrecision as CustomAssertCurrencyPrecision;
use Symfony\Component\Validator\Constraints as Assert;

final readonly class SaveCarrierRequest
{
    #[Assert\NotBlank]
    #[Assert\Length(min: 2, max: 255)]
    public string $name;

    #[Assert\GreaterThanOrEqual(0)]
    #[Assert\Type('numeric')]
    #[CustomAssertCurrencyPrecision]
    public string $fee;

    #[Assert\Valid]
    public ?FileData $fileData;

    public bool $isActive;

    public bool $isExternal;

    /** @var array<int, mixed> */
    public ?array $externalData;

    /**
     * @param array<int, mixed>    $externalData
     * @param array<string, mixed> $thumbnail
     */
    public function __construct(
        string $name,
        string $fee,
        mixed $isActive,
        mixed $isExternal,
        ?array $externalData,
        ?array $thumbnail
    ) {
        $this->name = $name;
        $this->fee = $fee;
        $this->isActive = BoolHelper::castOrFail($isActive, 'isActive');
        $this->isExternal = BoolHelper::castOrFail($isExternal, 'isExternal');
        $this->externalData = $externalData;
        $this->fileData = $thumbnail ? FileData::fromArray($thumbnail) : null;
    }
}
