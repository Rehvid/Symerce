<?php

declare(strict_types=1);

namespace App\Admin\UI\API;

use App\Admin\Application\DTO\Request\Customer\SaveCustomerRequest;
use App\Admin\Application\UseCase\Customer\CreateCustomerUseCase;
use App\Admin\Application\UseCase\Customer\DeleteCustomerUseCase;
use App\Admin\Application\UseCase\Customer\GetByIdCustomerUseCase;
use App\Admin\Application\UseCase\Customer\ListCustomerUseCase;
use App\Admin\Application\UseCase\Customer\UpdateCustomerUseCase;
use App\Shared\Application\UseCases\Base\CreateUseCaseInterface;
use App\Shared\Application\UseCases\Base\DeleteUseCaseInterface;
use App\Shared\Application\UseCases\Base\GetByIdUseCaseInterface;
use App\Shared\Application\UseCases\Base\ListUseCaseInterface;
use App\Shared\Application\UseCases\Base\UpdateUseCaseInterface;
use App\Shared\Infrastructure\Http\RequestDtoResolver;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

#[Route('/customers', name: 'customer_')]
final class CustomerController extends AbstractCrudController
{
    public function __construct(
        private readonly ListCustomerUseCase $listCustomerUseCase,
        private readonly UpdateCustomerUseCase $updateCustomerUseCase,
        private readonly DeleteCustomerUseCase $deleteCustomerUseCase,
        private readonly CreateCustomerUseCase $createCustomerUseCase,
        private readonly GetByIdCustomerUseCase $getByIdCustomerUseCase,
        RequestDtoResolver $requestDtoResolver,
        TranslatorInterface $translator
    ) {
        parent::__construct($requestDtoResolver, $translator);
    }


    protected function getListUseCase(): ListUseCaseInterface
    {
        return $this->listCustomerUseCase;
    }

    protected function getGetByIdUseCase(): GetByIdUseCaseInterface
    {
        return $this->getByIdCustomerUseCase;
    }

    protected function getCreateUseCase(): CreateUseCaseInterface
    {
        return $this->createCustomerUseCase;
    }

    protected function getUpdateUseCase(): UpdateUseCaseInterface
    {
        return $this->updateCustomerUseCase;
    }

    protected function getDeleteUseCase(): DeleteUseCaseInterface
    {
       return $this->deleteCustomerUseCase;
    }

    protected function getStoreRequestDtoClass(): string
    {
        return SaveCustomerRequest::class;
    }

    protected function getUpdateRequestDtoClass(): string
    {
        return SaveCustomerRequest::class;
    }
}
