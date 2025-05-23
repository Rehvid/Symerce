<?php

declare (strict_types = 1);

namespace App\Admin\UI\API;

use App\Admin\Application\DTO\Request\DeliveryTime\SaveDeliveryTimeRequest;
use App\Admin\Application\UseCase\DeliveryTime\CreateDeliveryTimeUseCase;
use App\Admin\Application\UseCase\DeliveryTime\DeleteDeliveryTimeUseCase;
use App\Admin\Application\UseCase\DeliveryTime\GetByIdDeliveryTimeUseCase;
use App\Admin\Application\UseCase\DeliveryTime\GetDeliveryTimeCreateDataUseCase;
use App\Admin\Application\UseCase\DeliveryTime\ListDeliveryTimeUseCase;
use App\Admin\Application\UseCase\DeliveryTime\UpdateDeliveryTimeUseCase;
use App\Admin\Infrastructure\Repository\DeliveryTimeDoctrineRepository;
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

#[Route('/delivery-time', name: 'delivery_time_')]
final class DeliveryTimeController extends AbstractCrudController implements UpdateOrderControllerInterface
{
    use UpdateOrderControllerTrait;

    public function __construct(
        private readonly ListDeliveryTimeUseCase $listDeliveryTimeUseCase,
        private readonly CreateDeliveryTimeUseCase $createDeliveryTimeUseCase,
        private readonly UpdateDeliveryTimeUseCase $updateDeliveryTimeUseCase,
        private readonly DeleteDeliveryTimeUseCase $deleteDeliveryTimeUseCase,
        private readonly GetByIdDeliveryTimeUseCase $getByIdDeliveryTimeUseCase,
        private readonly EntityManagerInterface $entityManager,
        private readonly DeliveryTimeDoctrineRepository $deliveryTimeDoctrineRepository,
        RequestDtoResolver $requestDtoResolver,
        TranslatorInterface $translator
    ) {
        parent::__construct($requestDtoResolver, $translator);
    }

    #[Route('/store-data', name: 'store_data', methods: ['GET'])]
    public function storeData(GetDeliveryTimeCreateDataUseCase $useCase): JsonResponse
    {
        return $this->json(
            data: new ApiResponse(
                data: $useCase->execute()
            )
        );
    }

    protected function getListUseCase(): ListUseCaseInterface
    {
        return $this->listDeliveryTimeUseCase;
    }

    protected function getGetByIdUseCase(): GetByIdUseCaseInterface
    {
        return $this->getByIdDeliveryTimeUseCase;
    }

    protected function getCreateUseCase(): CreateUseCaseInterface
    {
       return $this->createDeliveryTimeUseCase;
    }

    protected function getUpdateUseCase(): UpdateUseCaseInterface
    {
        return $this->updateDeliveryTimeUseCase;
    }

    protected function getDeleteUseCase(): DeleteUseCaseInterface
    {
        return $this->deleteDeliveryTimeUseCase;
    }

    protected function getStoreRequestDtoClass(): string
    {
        return SaveDeliveryTimeRequest::class;
    }

    protected function getUpdateRequestDtoClass(): string
    {
        return SaveDeliveryTimeRequest::class;
    }

    public function getOrderSortableRepository(): OrderSortableRepositoryInterface|AbstractRepository
    {
        return $this->deliveryTimeDoctrineRepository;
    }

    public function getEntityManager(): EntityManagerInterface
    {
        return $this->entityManager;
    }
}
