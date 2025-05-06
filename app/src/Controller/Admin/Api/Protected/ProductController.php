<?php

declare(strict_types=1);

namespace App\Controller\Admin\Api\Protected;

use App\Controller\Admin\AbstractCrudAdminController;
use App\DTO\Admin\Request\Product\SaveProductRequestDTO;
use App\Entity\Product;
use App\Interfaces\UpdateOrderControllerInterface;
use App\Mapper\Admin\ProductResponseMapper;
use App\Mapper\Interfaces\ResponseMapperInterface;
use App\Repository\Base\AbstractRepository;
use App\Repository\Interface\OrderSortableRepositoryInterface;
use App\Traits\UpdateOrderControllerTrait;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/products', name: 'products_')]
class ProductController extends AbstractCrudAdminController implements UpdateOrderControllerInterface
{
    use UpdateOrderControllerTrait;

    #[Route('/form-data', name: 'store_form_data', methods: ['GET'])]
    public function storeUpdateFormData(): JsonResponse
    {
        /** @var ProductResponseMapper $responseMapper */
        $responseMapper = $this->getResponseMapper();

        return $this->prepareJsonResponse(data: $responseMapper->mapToStoreFormDataResponse());
    }

    protected function getUpdateDtoClass(): string
    {
        return SaveProductRequestDTO::class;
    }

    protected function getStoreDtoClass(): string
    {
        return SaveProductRequestDTO::class;
    }

    protected function getResponseMapper(): ResponseMapperInterface
    {
        return $this->managerMapperResponse->get(ProductResponseMapper::class);
    }

    protected function getRepository(): AbstractRepository
    {
        return $this->getRepositoryInstanceForClass(Product::class);
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
