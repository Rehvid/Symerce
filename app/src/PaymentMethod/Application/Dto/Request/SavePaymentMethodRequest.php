<?php

declare(strict_types=1);

namespace App\PaymentMethod\Application\Dto\Request;

use App\Common\Application\Contracts\ArrayHydratableInterface;
use App\Common\Application\Dto\FileData;
use App\Common\Application\Dto\Request\RequestDtoInterface;
use Symfony\Component\Validator\Constraints as Assert;

final readonly class SavePaymentMethodRequest implements RequestDtoInterface, ArrayHydratableInterface
{

    /** @param array<string, mixed> $config */
    public function __construct(
        #[Assert\NotBlank] #[Assert\Length(min: 3)] public string $name,
        public string $fee,
        public string $code,
        public bool $isActive,
        public bool $isRequireWebhook,
        public array $config = [],
        public ?FileData $fileData = null,
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
