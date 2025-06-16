<?php

declare(strict_types=1);

namespace App\Product\Application\Command;

use App\Common\Application\Command\Interfaces\CommandInterface;
use App\Product\Application\Dto\ProductData;

final readonly class UpdateProductCommand implements CommandInterface
{
    public function __construct(
        public int $productId,
        public ProductData $data,
    ) {
    }
}
