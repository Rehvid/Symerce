<?php

declare(strict_types=1);

namespace App\Product\Application\Handler\Command;

use App\Common\Application\Command\Interfaces\CommandHandlerInterface;
use App\Common\Application\Dto\Response\IdResponse;
use App\Common\Application\Service\SlugService;
use App\Common\Domain\Entity\Product;
use App\Product\Application\Command\CreateProductCommand;
use App\Product\Application\Hydrator\ProductHydrator;
use App\Product\Domain\Repository\ProductRepositoryInterface;

final readonly class CreateProductCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private ProductRepositoryInterface $repository,
        private SlugService $slugService,
        private ProductHydrator $hydrator,
    ) {
    }

    public function __invoke(CreateProductCommand $command): IdResponse
    {
        $product = new Product();
        $product->setSlug($this->slugService->makeUnique(
            fallback: $command->data->name,
            proposed: $command->data->slug,
            entityClass: Product::class,
        ));
        $product = $this->hydrator->hydrate($command->data, $product);
        $product->setPosition($this->repository->getMaxPosition() + 1);

        $this->repository->save($product);

        return new IdResponse($product->getId());
    }
}
