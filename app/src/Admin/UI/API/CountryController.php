<?php

declare (strict_types = 1);

namespace App\Admin\UI\API;

use App\Admin\Application\DTO\Request\Country\SaveCountryRequest;
use App\Admin\Application\DTO\Request\Currency\SaveCurrencyRequest;
use App\Admin\Application\UseCase\Country\CreateCountryUseCase;
use App\Admin\Application\UseCase\Country\DeleteCountryUseCase;
use App\Admin\Application\UseCase\Country\GetByIdCountryUseCase;
use App\Admin\Application\UseCase\Country\ListCountryUseCase;
use App\Admin\Application\UseCase\Country\UpdateCountryUseCase;
use App\Shared\Application\UseCases\Base\CreateUseCaseInterface;
use App\Shared\Application\UseCases\Base\DeleteUseCaseInterface;
use App\Shared\Application\UseCases\Base\GetByIdUseCaseInterface;
use App\Shared\Application\UseCases\Base\ListUseCaseInterface;
use App\Shared\Application\UseCases\Base\UpdateUseCaseInterface;
use App\Shared\Infrastructure\Http\RequestDtoResolver;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Contracts\Translation\TranslatorInterface;

#[Route('/countries', name: 'country_')]
final class CountryController extends AbstractCrudController
{

    public function __construct(
        private readonly ListCountryUseCase $listCountryUseCase,
        private readonly CreateCountryUseCase $createCountryUseCase,
        private readonly UpdateCountryUseCase $updateCountryUseCase,
        private readonly DeleteCountryUseCase $deleteCountryUseCase,
        private readonly GetByIdCountryUseCase $getByIdUseCase,
        RequestDtoResolver $requestDtoResolver,
        TranslatorInterface $translator
    ) {
        parent::__construct($requestDtoResolver, $translator);
    }

    protected function getListUseCase(): ListUseCaseInterface
    {
        return $this->listCountryUseCase;
    }

    protected function getGetByIdUseCase(): GetByIdUseCaseInterface
    {
        return $this->getByIdUseCase;
    }

    protected function getCreateUseCase(): CreateUseCaseInterface
    {
        return $this->createCountryUseCase;
    }

    protected function getUpdateUseCase(): UpdateUseCaseInterface
    {
        return $this->updateCountryUseCase;
    }

    protected function getDeleteUseCase(): DeleteUseCaseInterface
    {
        return $this->deleteCountryUseCase;
    }

    protected function getStoreRequestDtoClass(): string
    {
        return SaveCountryRequest::class;
    }

    protected function getUpdateRequestDtoClass(): string
    {
        return SaveCountryRequest::class;
    }
}
