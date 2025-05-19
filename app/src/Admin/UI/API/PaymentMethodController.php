<?php

declare(strict_types=1);

namespace App\Admin\UI\API;

use App\Admin\Application\DTO\Request\PaymentMethod\SavePaymentMethodRequest;
use App\Admin\Application\UseCase\PaymentMethod\CreatePaymentMethodUseCase;
use App\Admin\Application\UseCase\PaymentMethod\DeletePaymentMethodUseCase;
use App\Admin\Application\UseCase\PaymentMethod\GetByIdPaymentMethodUseCase;
use App\Admin\Application\UseCase\PaymentMethod\ListPaymentMethodUseCase;
use App\Admin\Application\UseCase\PaymentMethod\UpdatePaymentMethodUseCase;
use App\Shared\Application\UseCases\Base\CreateUseCaseInterface;
use App\Shared\Application\UseCases\Base\DeleteUseCaseInterface;
use App\Shared\Application\UseCases\Base\GetByIdUseCaseInterface;
use App\Shared\Application\UseCases\Base\ListUseCaseInterface;
use App\Shared\Application\UseCases\Base\UpdateUseCaseInterface;
use App\Shared\Infrastructure\Http\RequestDtoResolver;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

#[Route('/payment-methods', name: 'payment_methods_')]
final class PaymentMethodController extends AbstractCrudController
{

    public function __construct(
        private readonly ListPaymentMethodUseCase $listCartUseCase,
        private readonly GetByIdPaymentMethodUseCase $getByIdUseCase,
        private readonly CreatePaymentMethodUseCase   $createUseCase,
        private readonly UpdatePaymentMethodUseCase   $updateUseCase,
        private readonly DeletePaymentMethodUseCase   $deleteUseCase,
        RequestDtoResolver                        $requestDtoResolver,
        TranslatorInterface $translator,
    ) {
        parent::__construct($requestDtoResolver, $translator);
    }

    protected function getListUseCase(): ListUseCaseInterface
    {
        return $this->listCartUseCase;
    }

    protected function getGetByIdUseCase(): GetByIdUseCaseInterface
    {
        return $this->getByIdUseCase;
    }

    protected function getCreateUseCase(): CreateUseCaseInterface
    {
        return $this->createUseCase;
    }

    protected function getUpdateUseCase(): UpdateUseCaseInterface
    {
        return $this->updateUseCase;
    }

    protected function getDeleteUseCase(): DeleteUseCaseInterface
    {
        return $this->deleteUseCase;
    }

    protected function getStoreRequestDtoClass(): string
    {
        return SavePaymentMethodRequest::class;
    }

    protected function getUpdateRequestDtoClass(): string
    {
        return SavePaymentMethodRequest::class;
    }
}
