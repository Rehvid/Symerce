<?php

declare(strict_types=1);

namespace App\Admin\Application\DTO\Request\PaymentMethod;

use App\Shared\Application\DTO\Request\RequestDtoInterface;
use Symfony\Component\Validator\Constraints as Assert;

final readonly class SavePaymentMethodRequest implements RequestDtoInterface
{

    /** @param array<string, mixed> $config */
    public function __construct(
        #[Assert\NotBlank] #[Assert\Length(min: 3)] public string $name,
        public string $fee,
        public string $code,
        public bool $isActive,
        public bool $isRequireWebhook,
        public array $config = [],
        public array $thumbnail = [],
        public ?int $id = null,
    ) {}
}
