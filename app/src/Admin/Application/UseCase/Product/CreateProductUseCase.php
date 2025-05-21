<?php

declare(strict_types=1);

namespace App\Admin\Application\UseCase\Product;

use App\Admin\Application\Hydrator\ProductHydrator;
use App\Admin\Domain\Entity\Product;
use App\Admin\Domain\Repository\ProductRepositoryInterface;
use App\Shared\Application\DTO\Request\RequestDtoInterface;
use App\Shared\Application\DTO\Response\IdResponse;
use App\Shared\Application\UseCases\Base\CreateUseCaseInterface;

final readonly class CreateProductUseCase implements CreateUseCaseInterface
{
    public function __construct(
        private ProductRepositoryInterface $productRepository,
        private ProductHydrator $hydrator,
    ) {

    }

    public function execute(RequestDtoInterface $requestDto): mixed
    {
        $product = new Product();
        $product->setOrder($this->productRepository->getMaxOrder() + 1);
        $product->setSlug($this->hydrator->saveSlug($requestDto->name, $requestDto->slug));

        $this->hydrator->hydrate($requestDto, $product);

        $this->productRepository->save($product);

        return (new IdResponse($product->getId()))->toArray();
    }
}
