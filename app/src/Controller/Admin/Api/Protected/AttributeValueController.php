<?php

declare(strict_types=1);

namespace App\Controller\Admin\Api\Protected;

use App\Controller\Admin\AbstractCrudAdminController;
use App\DTO\Admin\Request\AttributeValue\SaveAttributeValueRequestDTO;
use App\Entity\AttributeValue;
use App\Interfaces\UpdateOrderControllerInterface;
use App\Mapper\Admin\AttributeValueResponseMapper;
use App\Mapper\Interfaces\ResponseMapperInterface;
use App\Repository\Base\AbstractRepository;
use App\Repository\Interface\OrderSortableRepositoryInterface;
use App\Traits\UpdateOrderControllerTrait;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/attributes/{attributeId}/values', name: 'attribute_value_')]
class AttributeValueController extends AbstractCrudAdminController implements UpdateOrderControllerInterface
{
    use UpdateOrderControllerTrait;

    #[Route('', name: 'index', methods: ['GET'])]
    public function index(Request $request): JsonResponse
    {
        $paginatedResponse = $this->getPaginatedResponse(
            $request,
            $this->getRepository(),
            ['attributeId' => $request->get('attributeId')]
        );

        return $this->prepareJsonResponse(
            data: $this->getResponseMapper()->mapToIndexResponse($paginatedResponse->data),
            meta: $paginatedResponse->paginationMeta->toArray()
        );
    }

    protected function getUpdateDtoClass(): string
    {
        return SaveAttributeValueRequestDTO::class;
    }

    protected function getStoreDtoClass(): string
    {
        return SaveAttributeValueRequestDTO::class;
    }

    protected function getResponseMapper(): ResponseMapperInterface
    {
        return $this->managerMapperResponse->get(AttributeValueResponseMapper::class);
    }

    protected function getRepository(): AbstractRepository
    {
        return $this->getRepositoryInstanceForClass(AttributeValue::class);
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
