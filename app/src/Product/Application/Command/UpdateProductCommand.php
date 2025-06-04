<?php

declare(strict_types=1);

namespace App\Product\Application\Command;

use App\Product\Application\Dto\ProductData;
use App\Shared\Application\Command\CommandInterface;

final readonly class UpdateProductCommand implements CommandInterface
{
    public function __construct(
        public int $productId,
        public ProductData $data,
    ) {}
}
