<?php

declare(strict_types=1);

namespace App\Shop\Application\UseCase\Product;

use App\Common\Domain\Entity\Product;
use App\Shop\Application\Assembler\ProductAssembler;

final readonly class GetByIdProductUseCase
{
    public function __construct(
        private ProductAssembler $assembler,
    ) {}


    public function execute(Product $product): array
    {
        return $this->assembler->toShowResponse($product);
    }
}
