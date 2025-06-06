<?php

declare(strict_types=1);

namespace App\PaymentMethod\Application\Dto\Request;

use App\Common\Application\Contracts\ArrayHydratableInterface;
use App\Common\Application\Dto\FileData;
use App\Common\Domain\Entity\PaymentMethod;
use App\Common\Infrastructure\Validator\CurrencyPrecision as CustomAssertCurrencyPrecision;
use Symfony\Component\Validator\Constraints as Assert;
use App\Common\Infrastructure\Validator\UniqueEntityField as CustomAssertUniqueCode;

final readonly class SavePaymentMethodRequest implements ArrayHydratableInterface
{
    #[Assert\NotBlank]
    #[Assert\Length(min: 2, max: 255)]
    public string $name;

    #[Assert\GreaterThanOrEqual(0)]
    #[Assert\Type('numeric')]
    #[CustomAssertCurrencyPrecision]
    public string $fee;

    #[Assert\NotBlank]
    #[Assert\Length(min: 1, max: 100)]
    #[CustomAssertUniqueCode(options: ['field' => 'code', 'className' => PaymentMethod::class])]
    public string $code;

    public bool $isActive;

    #[Assert\NotBlank]
    public bool $isRequireWebhook;

    public ?array $config;

    public ?FileData $fileData;

    /** @param array<string, mixed> $config */
    public function __construct(
        string $name,
        string $fee,
        string $code,
        bool $isActive,
        bool $isRequireWebhook,
        array $config = [],
        ?FileData $fileData = null,
    ) {}

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
            code: $data['code'],
            isActive: $data['isActive'],
            isRequireWebhook: $data['isRequireWebhook'],
            config: $data['config'] ?? [],
            fileData: $fileData,
        );
    }
}
