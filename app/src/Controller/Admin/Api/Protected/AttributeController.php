<?php

declare(strict_types=1);

namespace App\Controller\Admin\Api\Protected;

use App\Controller\Admin\AbstractCrudAdminController;
use App\DTO\Admin\Request\Attribute\SaveAttributeRequestDTO;
use App\Entity\Attribute;
use App\Interfaces\UpdateOrderControllerInterface;
use App\Mapper\Admin\AttributeResponseMapper;
use App\Mapper\Interfaces\ResponseMapperInterface;
use App\Repository\Base\AbstractRepository;
use App\Repository\Interface\OrderSortableRepositoryInterface;
use App\Traits\UpdateOrderControllerTrait;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Attribute\Route;

#[Route('/attributes', name: 'attribute_')]
class AttributeController extends AbstractCrudAdminController implements UpdateOrderControllerInterface
{
    use UpdateOrderControllerTrait;

    protected function getUpdateDtoClass(): string
    {
        return SaveAttributeRequestDTO::class;
    }

    protected function getStoreDtoClass(): string
    {
        return SaveAttributeRequestDTO::class;
    }

    protected function getResponseMapper(): ResponseMapperInterface
    {
        return $this->managerMapperResponse->get(AttributeResponseMapper::class);
    }

    protected function getRepository(): AbstractRepository
    {
        return $this->getRepositoryInstanceForClass(Attribute::class);
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
