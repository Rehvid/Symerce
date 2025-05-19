<?php

declare(strict_types=1);

namespace App\Admin\UI\API;

use App\Admin\Application\DTO\Request\Product\SaveProductRequest;
use App\Admin\Application\UseCase\Product\CreateProductUseCase;
use App\Admin\Application\UseCase\Product\DeleteProductUseCase;
use App\Admin\Application\UseCase\Product\GetByIdProductUseCase;
use App\Admin\Application\UseCase\Product\GetProductCreateDataUseCase;
use App\Admin\Application\UseCase\Product\ListProductUseCase;
use App\Admin\Application\UseCase\Product\UpdateProductUseCase;
use App\Admin\Infrastructure\Repository\ProductDoctrineRepository;
use App\Interfaces\UpdateOrderControllerInterface;
use App\Repository\Base\AbstractRepository;
use App\Repository\Interface\OrderSortableRepositoryInterface;
use App\Service\RequestDtoResolver;
use App\Service\Response\ApiResponse;
use App\Shared\Application\UseCases\Base\CreateUseCaseInterface;
use App\Shared\Application\UseCases\Base\DeleteUseCaseInterface;
use App\Shared\Application\UseCases\Base\GetByIdUseCaseInterface;
use App\Shared\Application\UseCases\Base\ListUseCaseInterface;
use App\Shared\Application\UseCases\Base\UpdateUseCaseInterface;
use App\Traits\UpdateOrderControllerTrait;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

#[Route('/products', name: 'products_')]
final class ProductController extends AbstractCrudController
{

    public function __construct(
        private readonly CreateProductUseCase $createProductUseCase,
        private readonly UpdateProductUseCase $updateProductUseCase,
        private readonly DeleteProductUseCase $deleteProductUseCase,
        private readonly ListProductUseCase $listProductUseCase,
        private readonly GetByIdProductUseCase  $getByIdProductUseCase,
        private readonly EntityManagerInterface    $entityManager,
        private readonly ProductDoctrineRepository $productRepository,
        RequestDtoResolver                         $requestDtoResolver,
        TranslatorInterface                        $translator
    ) {
        parent::__construct($requestDtoResolver, $translator);
    }

    #[Route('/store-data', name: 'store_data', methods: ['GET'])]
    public function storeData(GetProductCreateDataUseCase $useCase): JsonResponse
    {
        return $this->json(
            data: new ApiResponse(
                data: $useCase->execute()
            )
        );
    }

    public function getOrderSortableRepository(): OrderSortableRepositoryInterface|AbstractRepository
    {
        return $this->productRepository;
    }

    public function getEntityManager(): EntityManagerInterface
    {
        return $this->entityManager;
    }

    protected function getListUseCase(): ListUseCaseInterface
    {
        return $this->listProductUseCase;
    }

    protected function getGetByIdUseCase(): GetByIdUseCaseInterface
    {
        return $this->getByIdProductUseCase;
    }

    protected function getCreateUseCase(): CreateUseCaseInterface
    {
        return $this->createProductUseCase;
    }

    protected function getUpdateUseCase(): UpdateUseCaseInterface
    {
        return $this->updateProductUseCase;
    }

    protected function getDeleteUseCase(): DeleteUseCaseInterface
    {
        return $this->deleteProductUseCase;
    }

    protected function getStoreRequestDtoClass(): string
    {
        return SaveProductRequest::class;
    }

    protected function getUpdateRequestDtoClass(): string
    {
        return SaveProductRequest::class;
    }
}
