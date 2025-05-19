<?php

declare(strict_types=1);

namespace App\Admin\UI\API;

use App\Admin\Application\DTO\Request\Category\SaveCategoryRequest;
use App\Admin\Application\UseCase\Category\CreateCategoryUseCase;
use App\Admin\Application\UseCase\Category\DeleteCategoryUseCase;
use App\Admin\Application\UseCase\Category\GetByIdCategoryUseCase;
use App\Admin\Application\UseCase\Category\GetCategoryCreateDataUseCase;
use App\Admin\Application\UseCase\Category\ListCategoryUseCase;
use App\Admin\Application\UseCase\Category\UpdateCategoryUseCase;
use App\Admin\Infrastructure\Repository\CategoryDoctrineRepository;
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
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

#[Route('/categories', name: 'category_')]
final class CategoryController extends AbstractCrudController
{
    public function __construct(
        private readonly ListCategoryUseCase        $listCategoryUseCase,
        private readonly GetByIdCategoryUseCase     $getByIdCategoryUseCase,
        private readonly CreateCategoryUseCase      $createCategoryUseCase,
        private readonly UpdateCategoryUseCase      $updateCategoryUseCase,
        private readonly DeleteCategoryUseCase      $deleteCategoryUseCase,
        RequestDtoResolver                          $requestDtoResolver,
        TranslatorInterface                         $translator
    ) {
        parent::__construct($requestDtoResolver, $translator);
    }

    #[Route('/store-data', name: 'store_data', methods: ['GET'])]
    public function storeData(GetCategoryCreateDataUseCase $useCase): JsonResponse
    {
        return $this->json(
            data: new ApiResponse(
                data: $useCase->execute()
            )
        );
    }

    protected function getListUseCase(): ListUseCaseInterface
    {
        return $this->listCategoryUseCase;
    }

    protected function getGetByIdUseCase(): GetByIdUseCaseInterface
    {
        return $this->getByIdCategoryUseCase;
    }

    protected function getCreateUseCase(): CreateUseCaseInterface
    {
        return $this->createCategoryUseCase;
    }

    protected function getUpdateUseCase(): UpdateUseCaseInterface
    {
        return $this->updateCategoryUseCase;
    }

    protected function getDeleteUseCase(): DeleteUseCaseInterface
    {
        return $this->deleteCategoryUseCase;
    }

    protected function getStoreRequestDtoClass(): string
    {
        return SaveCategoryRequest::class;
    }

    protected function getUpdateRequestDtoClass(): string
    {
        return SaveCategoryRequest::class;
    }
}
