<?php

declare(strict_types=1);

namespace App\Admin\Application\UseCase\Product;

use App\Admin\Application\Hydrator\ProductHydrator;
use App\Admin\Domain\Repository\ProductRepositoryInterface;
use App\Shared\Application\DTO\Request\RequestDtoInterface;
use App\Shared\Application\DTO\Response\IdResponse;
use App\Shared\Application\UseCases\Base\UpdateUseCaseInterface;
use Doctrine\ORM\EntityNotFoundException;

final readonly class UpdateProductUseCase implements UpdateUseCaseInterface
{
    public function __construct(
        private ProductRepositoryInterface $productRepository,
        private ProductHydrator $hydrator,
    ) {

    }


    public function execute(RequestDtoInterface $requestDto, int|string $entityId): mixed
    {
        $product = $this->productRepository->findById($entityId);
        if (null === $product) {
            throw new EntityNotFoundException();
        }
        if ($product->getSlug() !== $requestDto->slug) {
            $product->setSlug($this->hydrator->generateSlug($requestDto->slug));
        }

        $this->hydrator->hydrate($requestDto, $product);

        $this->productRepository->save($product);

        return (new IdResponse($product->getId()))->toArray();
    }
}
