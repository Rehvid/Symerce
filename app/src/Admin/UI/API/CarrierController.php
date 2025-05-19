<?php

declare(strict_types=1);

namespace App\Admin\UI\API;

use App\Admin\Application\DTO\Request\Carrier\SaveCarrierRequest;
use App\Admin\Application\UseCase\Carrier\CreateCarrierUseCase;
use App\Admin\Application\UseCase\Carrier\DeleteCarrierUseCase;
use App\Admin\Application\UseCase\Carrier\GetByIdCarrierUseCase;
use App\Admin\Application\UseCase\Carrier\ListCarrierUseCase;
use App\Admin\Application\UseCase\Carrier\UpdateCarrierUseCase;
use App\Shared\Application\UseCases\Base\CreateUseCaseInterface;
use App\Shared\Application\UseCases\Base\DeleteUseCaseInterface;
use App\Shared\Application\UseCases\Base\GetByIdUseCaseInterface;
use App\Shared\Application\UseCases\Base\ListUseCaseInterface;
use App\Shared\Application\UseCases\Base\UpdateUseCaseInterface;
use App\Shared\Infrastructure\Http\RequestDtoResolver;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

#[Route('/carriers', name: 'carrier_')]
final class CarrierController extends AbstractCrudController
{

    public function __construct(
        private readonly CreateCarrierUseCase $createCarrierUseCase,
        private readonly UpdateCarrierUseCase $updateCarrierUseCase,
        private readonly DeleteCarrierUseCase $deleteCarrierUseCase,
        private readonly ListCarrierUseCase $listCarrierUseCase,
        private readonly GetByIdCarrierUseCase $getByIdCarrierUseCase,
        RequestDtoResolver $requestDtoResolver,
        TranslatorInterface $translator
    ) {
        parent::__construct($requestDtoResolver, $translator);
    }

    protected function getListUseCase(): ListUseCaseInterface
    {
        return $this->listCarrierUseCase;
    }

    protected function getGetByIdUseCase(): GetByIdUseCaseInterface
    {
        return $this->getByIdCarrierUseCase;
    }

    protected function getCreateUseCase(): CreateUseCaseInterface
    {
        return $this->createCarrierUseCase;
    }

    protected function getUpdateUseCase(): UpdateUseCaseInterface
    {
        return $this->updateCarrierUseCase;
    }

    protected function getDeleteUseCase(): DeleteUseCaseInterface
    {
        return $this->deleteCarrierUseCase;
    }

    protected function getStoreRequestDtoClass(): string
    {
        return SaveCarrierRequest::class;
    }

    protected function getUpdateRequestDtoClass(): string
    {
        return SaveCarrierRequest::class;
    }
}
