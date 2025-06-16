<?php

declare(strict_types=1);

namespace App\Product\Application\Handler\Query;

use App\Common\Application\Query\Interfaces\QueryHandlerInterface;
use App\Common\Domain\Entity\Product;
use App\Common\Domain\Exception\EntityNotFoundException;
use App\Product\Application\Assembler\ProductAssembler;
use App\Product\Application\Query\GetProductHistoryQuery;
use App\Product\Domain\Repository\ProductRepositoryInterface;

final readonly class ProductHistoryQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private ProductRepositoryInterface $repository,
        private ProductAssembler $assembler,
    ) {
    }

    public function __invoke(GetProductHistoryQuery $query): array
    {
        $product = $this->repository->findById($query->productId);
        if (null === $product) {
            throw EntityNotFoundException::for(Product::class, $query->productId);
        }

        return $this->assembler->toProductHistoryResponse($product);
    }
}
