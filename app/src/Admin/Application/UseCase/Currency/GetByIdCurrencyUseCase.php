<?php

declare(strict_types=1);

namespace App\Admin\Application\UseCase\Currency;

use App\Admin\Application\Assembler\CurrencyAssembler;
use App\Admin\Domain\Repository\CurrencyRepositoryInterface;
use App\Shared\Application\UseCases\Base\GetByIdUseCaseInterface;
use Doctrine\ORM\EntityNotFoundException;

final readonly class GetByIdCurrencyUseCase implements GetByIdUseCaseInterface
{
    public function __construct(
        private CurrencyAssembler $assembler,
        private CurrencyRepositoryInterface $repository,
    ) {}


    public function execute(int|string $entityId): array
    {
        $currency = $this->repository->findById($entityId);
        if (null === $currency) {
            throw new EntityNotFoundException();
        }

        return $this->assembler->toFormDataResponse($currency);
    }
}
