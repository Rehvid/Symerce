<?php

declare(strict_types=1);

namespace App\Admin\UI\API;

use App\Admin\Application\DTO\Request\AttributeValue\SaveAttributeValueRequest;
use App\Admin\Application\UseCase\AttributeValue\CreateAttributeValueUseCase;
use App\Admin\Application\UseCase\AttributeValue\DeleteAttributeValueUseCase;
use App\Admin\Application\UseCase\AttributeValue\GetByIdAttributeValueUseCase;
use App\Admin\Application\UseCase\AttributeValue\ListAttributeValueUseCase;
use App\Admin\Application\UseCase\AttributeValue\UpdateAttributeValueUseCase;
use App\Admin\Infrastructure\Repository\AttributeValueDoctrineRepository;
use App\Interfaces\UpdateOrderControllerInterface;
use App\Shared\Application\UseCases\Base\CreateUseCaseInterface;
use App\Shared\Application\UseCases\Base\DeleteUseCaseInterface;
use App\Shared\Application\UseCases\Base\GetByIdUseCaseInterface;
use App\Shared\Application\UseCases\Base\ListUseCaseInterface;
use App\Shared\Application\UseCases\Base\UpdateUseCaseInterface;
use App\Shared\Infrastructure\Http\RequestDtoResolver;
use App\Traits\UpdateOrderControllerTrait;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

#[Route('/attributes/{attributeId}/values', name: 'attribute_value_')]
final class AttributeValueController extends AbstractCrudController
{
    public function __construct(
        private readonly ListAttributeValueUseCase $listAttributeValueUseCase,
        private readonly CreateAttributeValueUseCase $createAttributeValueUseCase,
        private readonly UpdateAttributeValueUseCase $updateAttributeValueUseCase,
        private readonly DeleteAttributeValueUseCase $deleteAttributeValueUseCase,
        private readonly GetByIdAttributeValueUseCase $getByIdAttributeValueUseCase,
        private readonly EntityManagerInterface           $entityManager,
        private readonly AttributeValueDoctrineRepository $repository,
        RequestDtoResolver                                $requestDtoResolver,
        TranslatorInterface                               $translator
    ) {
        parent::__construct($requestDtoResolver, $translator);
    }

    protected function getListUseCase(): ListUseCaseInterface
    {
        return $this->listAttributeValueUseCase;
    }

    protected function getGetByIdUseCase(): GetByIdUseCaseInterface
    {
        return $this->getByIdAttributeValueUseCase;
    }

    protected function getCreateUseCase(): CreateUseCaseInterface
    {
        return $this->createAttributeValueUseCase;
    }

    protected function getUpdateUseCase(): UpdateUseCaseInterface
    {
        return $this->updateAttributeValueUseCase;
    }

    protected function getDeleteUseCase(): DeleteUseCaseInterface
    {
        return $this->deleteAttributeValueUseCase;
    }

    protected function getStoreRequestDtoClass(): string
    {
        return SaveAttributeValueRequest::class;
    }

    protected function getUpdateRequestDtoClass(): string
    {
        return SaveAttributeValueRequest::class;
    }
}
