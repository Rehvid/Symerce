<?php

declare(strict_types=1);

namespace App\Carrier\Application\Dto\Response;

use App\Common\Domain\ValueObject\MoneyVO;

final readonly class CarrierListResponse
{
    public function __construct(
        public int     $id,
        public string  $name,
        public bool    $isActive,
        public MoneyVO $fee,
        public ?string $imagePath,
    ) {
    }
}
