<?php

declare(strict_types=1);

namespace App\Controller\Admin\Api\Protected;

use App\Controller\Admin\AbstractCrudAdminController;
use App\DTO\Admin\Request\Category\SaveCategoryRequestDTO;
use App\Entity\Category;
use App\Interfaces\UpdateOrderControllerInterface;
use App\Mapper\Admin\CategoryResponseMapper;
use App\Mapper\Interfaces\ResponseMapperInterface;
use App\Repository\Base\AbstractRepository;
use App\Repository\Interface\OrderSortableRepositoryInterface;
use App\Traits\UpdateOrderControllerTrait;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/categories', name: 'category_')]
class CategoryController extends AbstractCrudAdminController implements UpdateOrderControllerInterface
{
    use UpdateOrderControllerTrait;

    #[Route('/form-data', name: 'store_form_data', methods: ['GET'])]
    public function storeUpdateFormData(): JsonResponse
    {
        /** @var CategoryResponseMapper $responseMapper */
        $responseMapper = $this->getResponseMapper();

        return $this->prepareJsonResponse(
            data: $responseMapper->mapToStoreFormDataResponse(),
        );
    }

    protected function getUpdateDtoClass(): string
    {
        return SaveCategoryRequestDTO::class;
    }

    protected function getStoreDtoClass(): string
    {
        return SaveCategoryRequestDTO::class;
    }

    protected function getResponseMapper(): ResponseMapperInterface
    {
        return $this->managerMapperResponse->get(CategoryResponseMapper::class);
    }

    protected function getRepository(): AbstractRepository
    {
        return $this->getRepositoryInstanceForClass(Category::class);
    }

    public function getEntityManager(): EntityManagerInterface
    {
        return $this->entityManager;
    }

    public function getOrderSortableRepository(): OrderSortableRepositoryInterface
    {
        return $this->getRepository();
    }
}
