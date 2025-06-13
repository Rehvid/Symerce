<?php

declare(strict_types=1);

namespace App\Order\Application\Dto\Request;

use Symfony\Component\Validator\Constraints as Assert;

final readonly class SaveOrderProductRequest
{
    #[Assert\GreaterThan(0)]
    public int $productId;

    #[Assert\GreaterThan(0)]
    public int|string $quantity;

    public function __construct(
        int $productId,
        int|string $quantity
    ) {
        $this->productId = $productId;
        $this->quantity = $quantity;
    }
}
