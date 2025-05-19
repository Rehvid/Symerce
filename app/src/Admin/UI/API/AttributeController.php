<?php

declare(strict_types=1);

namespace App\Admin\UI\API;

use App\Admin\Application\DTO\Request\Attribute\SaveAttributeRequest;
use App\Admin\Application\UseCase\Attribute\CreateAttributeUseCase;
use App\Admin\Application\UseCase\Attribute\DeleteAttributeUseCase;
use App\Admin\Application\UseCase\Attribute\GetByIdAttributeUseCase;
use App\Admin\Application\UseCase\Attribute\ListAttributeUseCase;
use App\Admin\Application\UseCase\Attribute\UpdateAttributeUseCase;
use App\Admin\Infrastructure\Repository\AttributeDoctrineRepository;
use App\Interfaces\UpdateOrderControllerInterface;
use App\Repository\Base\AbstractRepository;
use App\Repository\Interface\OrderSortableRepositoryInterface;
use App\Service\RequestDtoResolver;
use App\Shared\Application\UseCases\Base\CreateUseCaseInterface;
use App\Shared\Application\UseCases\Base\DeleteUseCaseInterface;
use App\Shared\Application\UseCases\Base\GetByIdUseCaseInterface;
use App\Shared\Application\UseCases\Base\ListUseCaseInterface;
use App\Shared\Application\UseCases\Base\UpdateUseCaseInterface;
use App\Traits\UpdateOrderControllerTrait;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

#[Route('/attributes', name: 'attribute_')]
final class AttributeController extends AbstractCrudController
{
    public function __construct(
        private readonly ListAttributeUseCase $listAttributeUseCase,
        private readonly CreateAttributeUseCase $createAttributeUseCase,
        private readonly UpdateAttributeUseCase $updateAttributeUseCase,
        private readonly DeleteAttributeUseCase $deleteAttributeUseCase,
        private readonly GetByIdAttributeUseCase $getByIdAttributeUseCase,
        RequestDtoResolver                           $requestDtoResolver,
        TranslatorInterface                          $translator
    ) {
        parent::__construct($requestDtoResolver, $translator);
    }

    protected function getListUseCase(): ListUseCaseInterface
    {
        return $this->listAttributeUseCase;
    }

    protected function getGetByIdUseCase(): GetByIdUseCaseInterface
    {
        return $this->getByIdAttributeUseCase;
    }

    protected function getCreateUseCase(): CreateUseCaseInterface
    {
        return $this->createAttributeUseCase;
    }

    protected function getUpdateUseCase(): UpdateUseCaseInterface
    {
        return $this->updateAttributeUseCase;
    }

    protected function getDeleteUseCase(): DeleteUseCaseInterface
    {
        return $this->deleteAttributeUseCase;
    }

    protected function getStoreRequestDtoClass(): string
    {
        return SaveAttributeRequest::class;
    }

    protected function getUpdateRequestDtoClass(): string
    {
        return SaveAttributeRequest::class;
    }
}
