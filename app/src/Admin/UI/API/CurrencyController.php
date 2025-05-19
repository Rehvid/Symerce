<?php

declare(strict_types=1);

namespace App\Admin\UI\API;

use App\Admin\Application\DTO\Request\Currency\SaveCurrencyRequest;
use App\Admin\Application\UseCase\Currency\CreateCurrencyUseCase;
use App\Admin\Application\UseCase\Currency\DeleteCurrencyUseCase;
use App\Admin\Application\UseCase\Currency\GetByIdCurrencyUseCase;
use App\Admin\Application\UseCase\Currency\ListCurrencyUseCase;
use App\Admin\Application\UseCase\Currency\UpdateCurrencyUseCase;
use App\Service\RequestDtoResolver;
use App\Shared\Application\UseCases\Base\CreateUseCaseInterface;
use App\Shared\Application\UseCases\Base\DeleteUseCaseInterface;
use App\Shared\Application\UseCases\Base\GetByIdUseCaseInterface;
use App\Shared\Application\UseCases\Base\ListUseCaseInterface;
use App\Shared\Application\UseCases\Base\UpdateUseCaseInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

#[Route('/currencies', name: 'currency_')]
final class CurrencyController extends AbstractCrudController
{

    public function __construct(
        private readonly ListCurrencyUseCase    $listCurrencyUseCase,
        private readonly CreateCurrencyUseCase  $createCurrencyUseCase,
        private readonly UpdateCurrencyUseCase  $updateCurrencyUseCase,
        private readonly DeleteCurrencyUseCase  $deleteCurrencyUseCase,
        private readonly GetByIdCurrencyUseCase $getByIdCurrencyUseCase,
        RequestDtoResolver                      $requestDtoResolver,
        TranslatorInterface                     $translator
    ) {
        parent::__construct($requestDtoResolver, $translator);
    }

    protected function getListUseCase(): ListUseCaseInterface
    {
        return $this->listCurrencyUseCase;
    }

    protected function getGetByIdUseCase(): GetByIdUseCaseInterface
    {
        return $this->getByIdCurrencyUseCase;
    }

    protected function getCreateUseCase(): CreateUseCaseInterface
    {
        return $this->createCurrencyUseCase;
    }

    protected function getUpdateUseCase(): UpdateUseCaseInterface
    {
        return $this->updateCurrencyUseCase;
    }

    protected function getDeleteUseCase(): DeleteUseCaseInterface
    {
        return $this->deleteCurrencyUseCase;
    }

    protected function getStoreRequestDtoClass(): string
    {
        return SaveCurrencyRequest::class;
    }

    protected function getUpdateRequestDtoClass(): string
    {
        return SaveCurrencyRequest::class;
    }
}
