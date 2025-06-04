<?php

declare(strict_types=1);

namespace App\Product\Application\Command;

use App\Product\Application\Dto\ProductData;
use App\Shared\Application\Command\CommandInterface;

final readonly class CreateProductCommand implements CommandInterface
{
    public function __construct(
        public ProductData $data
    ){}
}
