<?php

namespace App\Admin\Application\UseCase\Product;

use App\Admin\Domain\Repository\ProductRepositoryInterface;
use App\Shared\Application\UseCases\Base\DeleteUseCaseInterface;
use Doctrine\ORM\EntityNotFoundException;

final readonly class DeleteProductUseCase implements DeleteUseCaseInterface
{
    public function __construct(
        private ProductRepositoryInterface $productRepository,
    ) {

    }

    public function execute(int|string $entityId): void
    {
        $product = $this->productRepository->findById($entityId);
        if ($product === null) {
            throw new EntityNotFoundException();
        }

        $this->productRepository->remove($product);
    }
}
