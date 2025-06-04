<?php

declare(strict_types=1);

namespace App\Product\Application\Handler\Command;

use App\Common\Application\Command\Interfaces\CommandHandlerInterface;
use App\Common\Application\Dto\Response\IdResponse;
use App\Common\Application\Service\SlugService;
use App\Common\Domain\Entity\Product;
use App\Common\Domain\Exception\EntityNotFoundException;
use App\Product\Application\Command\UpdateProductCommand;
use App\Product\Application\Hydrator\ProductHydrator;
use App\Product\Domain\Repository\ProductRepositoryInterface;

final readonly class UpdateProductCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private ProductRepositoryInterface $repository,
        private ProductHydrator $hydrator,
        private SlugService $slugService
    ) {}

    public function __invoke(UpdateProductCommand $command): IdResponse
    {
        /** @var ?Product $product */
        $product = $this->repository->findById($command->productId);
        if (null === $product) {
            throw EntityNotFoundException::for(Product::class, $command->productId);
        }

        $data = $command->data;

        $category = $this->hydrator->hydrate($data, $product);

        if ($data->slug !== $product->getSlug()) {
            $product->setSlug($this->slugService->makeUnique(
                fallback: $category->getSlug(),
                proposed: $data->slug,
                entityClass: Product::class
            ));
        }

        $this->repository->save($category);

        return new IdResponse($category->getId());
    }
}
