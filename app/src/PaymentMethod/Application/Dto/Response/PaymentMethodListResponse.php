<?php

declare(strict_types=1);

namespace App\PaymentMethod\Application\Dto\Response;

use App\Common\Domain\ValueObject\MoneyVO;

final readonly class PaymentMethodListResponse
{
    public function __construct(
        public int     $id,
        public string  $name,
        public string  $code,
        public bool    $isActive,
        public MoneyVO $fee,
        public ?string $imagePath
    ) {
    }
}
