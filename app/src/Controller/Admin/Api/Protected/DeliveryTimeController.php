<?php

declare(strict_types=1);

namespace App\Controller\Admin\Api\Protected;

use App\Controller\Admin\AbstractCrudAdminController;
use App\DTO\Request\DeliveryTime\SaveDeliveryTimeRequestDTO;
use App\Entity\DeliveryTime;
use App\Interfaces\UpdateOrderControllerInterface;
use App\Mapper\DeliveryTimeResponseMapper;
use App\Mapper\Interfaces\ResponseMapperInterface;
use App\Repository\Base\AbstractRepository;
use App\Repository\Interface\OrderSortableRepositoryInterface;
use App\Traits\UpdateOrderControllerTrait;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/delivery-time', name: 'delivery_time_')]
class DeliveryTimeController extends AbstractCrudAdminController implements UpdateOrderControllerInterface
{
    use UpdateOrderControllerTrait;


    #[Route('/form-data', name: 'store_form_data', methods: ['GET'])]
    public function showStoreFormData(): JsonResponse
    {
        /** @var DeliveryTimeResponseMapper $responseMapper */
        $responseMapper = $this->getResponseMapper();

        return $this->prepareJsonResponse(
            data: $responseMapper->mapToStoreFormDataResponse(),
        );
    }

    protected function getUpdateDtoClass(): string
    {
       return SaveDeliveryTimeRequestDTO::class;
    }

    protected function getStoreDtoClass(): string
    {
        return SaveDeliveryTimeRequestDTO::class;
    }

    protected function getResponseMapper(): ResponseMapperInterface
    {
        return $this->managerMapperResponse->get(DeliveryTimeResponseMapper::class);
    }

    protected function getRepository(): AbstractRepository
    {
        return $this->getRepositoryInstanceForClass(DeliveryTime::class);
    }

    public function getOrderSortableRepository(): OrderSortableRepositoryInterface|AbstractRepository
    {
        return $this->getRepository();
    }

    public function getEntityManager(): EntityManagerInterface
    {
        return $this->entityManager;
    }
}
