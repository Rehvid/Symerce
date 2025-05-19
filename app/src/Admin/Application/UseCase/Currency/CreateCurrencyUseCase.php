<?php

declare (strict_types = 1);

namespace App\Admin\Application\UseCase\Currency;

use App\Admin\Application\Hydrator\CurrencyHydrator;
use App\Admin\Domain\Repository\CurrencyRepositoryInterface;
use App\Entity\Currency;
use App\Shared\Application\DTO\Request\RequestDtoInterface;
use App\Shared\Application\DTO\Response\IdResponse;
use App\Shared\Application\UseCases\Base\CreateUseCaseInterface;

final readonly class CreateCurrencyUseCase implements CreateUseCaseInterface
{
    public function __construct(
        private CurrencyHydrator $hydrator,
        private CurrencyRepositoryInterface $repository
    ) {}

    public function execute(RequestDtoInterface $requestDto): array
    {
       $currency = new Currency();

       $this->hydrator->hydrate($requestDto, $currency);
       $this->repository->save($currency);

       return (new IdResponse($currency->getId()))->toArray();
    }
}
