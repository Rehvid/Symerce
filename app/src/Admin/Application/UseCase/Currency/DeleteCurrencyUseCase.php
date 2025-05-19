<?php

declare(strict_types=1);

namespace App\Admin\Application\UseCase\Currency;

use App\Admin\Domain\Repository\CurrencyRepositoryInterface;
use App\Shared\Application\UseCases\Base\DeleteUseCaseInterface;
use Doctrine\ORM\EntityNotFoundException;

final readonly class DeleteCurrencyUseCase implements DeleteUseCaseInterface
{
    public function __construct(
        private CurrencyRepositoryInterface $currencyRepository,
    ) {}

    public function execute(int|string $entityId): void
    {
        $currency = $this->currencyRepository->findById($entityId);
        if (null === $currency) {
            throw new EntityNotFoundException();
        }

        $this->currencyRepository->remove($currency);
    }
}
