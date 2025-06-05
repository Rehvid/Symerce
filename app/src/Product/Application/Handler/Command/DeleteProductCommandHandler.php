<?php

declare(strict_types=1);

namespace App\Product\Application\Handler\Command;

use App\Common\Application\Command\Interfaces\CommandHandlerInterface;
use App\Common\Domain\Entity\Product;
use App\Common\Domain\Exception\EntityNotFoundException;
use App\Product\Application\Command\DeleteProductCommand;
use App\Product\Domain\Repository\ProductRepositoryInterface;

final readonly class DeleteProductCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private ProductRepositoryInterface $repository
    ) {}

    public function __invoke(DeleteProductCommand $command): void
    {
        /** @var ?Product $product */
        $product = $this->repository->findById($command->productId);
        if (null === $product) {
            throw EntityNotFoundException::for(Product::class, $command->productId);
        }

        $this->repository->remove($product);
    }
}
