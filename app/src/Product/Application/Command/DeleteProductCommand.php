<?php

declare(strict_types=1);

namespace App\Product\Application\Command;

use App\Common\Application\Command\Interfaces\CommandInterface;

final readonly class DeleteProductCommand implements CommandInterface
{
    public function __construct(
        public int $productId
    ) {
    }
}
