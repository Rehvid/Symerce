<?php

declare(strict_types=1);

namespace App\Product\Application\Handler\Query;

use App\Common\Domain\Entity\Product;
use App\Common\Domain\Exception\EntityNotFoundException;
use App\Product\Application\Assembler\ProductAssembler;
use App\Product\Application\Query\GetProductForEditQuery;
use App\Product\Domain\Repository\ProductRepositoryInterface;
use App\Shared\Application\Query\QueryHandlerInterface;

final readonly class ProductForEditQueryHandler implements QueryHandlerInterface
{
    public function __construct(
        private ProductAssembler $assembler,
        private ProductRepositoryInterface $repository
    ) {}

    public function __invoke(GetProductForEditQuery $query): array
    {
        /** @var Product $product */
        $product = $this->repository->findById($query->productId);
        if (null === $product) {
            throw EntityNotFoundException::for(Product::class, $query->productId);
        }

        return $this->assembler->toFormDataResponse($product);
    }
}
