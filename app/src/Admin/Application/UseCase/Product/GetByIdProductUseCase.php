<?php

declare(strict_types=1);

namespace App\Admin\Application\UseCase\Product;

use App\Admin\Application\Assembler\ProductAssembler;
use App\Admin\Domain\Repository\ProductRepositoryInterface;
use App\Shared\Application\UseCases\Base\GetByIdUseCaseInterface;
use Doctrine\ORM\EntityNotFoundException;

final readonly class GetByIdProductUseCase implements GetByIdUseCaseInterface
{
    public function __construct(
        private ProductRepositoryInterface $productRepository,
        private ProductAssembler $assembler
    ) {

    }

    public function execute(int|string $entityId): mixed
    {
        $product = $this->productRepository->findById($entityId);
        if (null === $product) {
            throw new EntityNotFoundException();
        }

        return $this->assembler->toFormDataResponse($product);
    }
}
