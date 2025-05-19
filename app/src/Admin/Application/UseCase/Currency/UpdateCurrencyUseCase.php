<?php

declare(strict_types=1);

namespace App\Admin\Application\UseCase\Currency;

use App\Admin\Application\Hydrator\CurrencyHydrator;
use App\Admin\Domain\Repository\CurrencyRepositoryInterface;
use App\Shared\Application\DTO\Request\RequestDtoInterface;
use App\Shared\Application\DTO\Response\IdResponse;
use App\Shared\Application\UseCases\Base\UpdateUseCaseInterface;
use Doctrine\ORM\EntityNotFoundException;

final readonly class UpdateCurrencyUseCase implements UpdateUseCaseInterface
{
    public function __construct(
       private CurrencyHydrator $hydrator,
       private CurrencyRepositoryInterface $repository
    ) {
    }


    public function execute(RequestDtoInterface $requestDto, int|string $entityId): mixed
    {
        $currency = $this->repository->findById($entityId);
        if (null === $currency) {
            throw new EntityNotFoundException();
        }

        $this->hydrator->hydrate($requestDto, $currency);

        $this->repository->save($currency);

        return (new IdResponse($currency->getId()))->toArray();
    }
}
