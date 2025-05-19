<?php

declare(strict_types=1);

namespace App\Admin\UI\API;

use App\Admin\Application\DTO\Request\Vendor\SaveVendorRequest;
use App\Admin\Application\UseCase\Vendor\CreateVendorUseCase;
use App\Admin\Application\UseCase\Vendor\DeleteVendorUseCase;
use App\Admin\Application\UseCase\Vendor\GetByIdVendorUseCase;
use App\Admin\Application\UseCase\Vendor\ListVendorUseCase;
use App\Admin\Application\UseCase\Vendor\UpdateVendorUseCase;
use App\Service\RequestDtoResolver;
use App\Shared\Application\UseCases\Base\CreateUseCaseInterface;
use App\Shared\Application\UseCases\Base\DeleteUseCaseInterface;
use App\Shared\Application\UseCases\Base\GetByIdUseCaseInterface;
use App\Shared\Application\UseCases\Base\ListUseCaseInterface;
use App\Shared\Application\UseCases\Base\UpdateUseCaseInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

#[Route('/vendors', name: 'vendor_')]
final class VendorController extends AbstractCrudController
{
    public function __construct(
        private readonly ListVendorUseCase $listVendorUseCase,
        private readonly CreateVendorUseCase $createVendorUseCase,
        private readonly UpdateVendorUseCase $updateVendorUseCase,
        private readonly DeleteVendorUseCase $deleteVendorUseCase,
        private readonly GetByIdVendorUseCase $getByIdVendorUseCase,
        RequestDtoResolver $requestDtoResolver,
        TranslatorInterface $translator
    ) {
        parent::__construct($requestDtoResolver, $translator);
    }

    protected function getListUseCase(): ListUseCaseInterface
    {
        return $this->listVendorUseCase;
    }

    protected function getGetByIdUseCase(): GetByIdUseCaseInterface
    {
        return $this->getByIdVendorUseCase;
    }

    protected function getCreateUseCase(): CreateUseCaseInterface
    {
        return $this->createVendorUseCase;
    }

    protected function getUpdateUseCase(): UpdateUseCaseInterface
    {
        return $this->updateVendorUseCase;
    }

    protected function getDeleteUseCase(): DeleteUseCaseInterface
    {
        return $this->deleteVendorUseCase;
    }

    protected function getStoreRequestDtoClass(): string
    {
        return SaveVendorRequest::class;
    }

    protected function getUpdateRequestDtoClass(): string
    {
        return SaveVendorRequest::class;
    }
}
