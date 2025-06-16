<?php

declare(strict_types=1);

namespace App\Currency\Application\Handler\Command;

use App\Common\Application\Command\Interfaces\CommandHandlerInterface;
use App\Common\Domain\Entity\Currency;
use App\Common\Domain\Exception\EntityNotFoundException;
use App\Currency\Application\Command\DeleteCurrencyCommand;
use App\Currency\Domain\Repository\CurrencyRepositoryInterface;

final readonly class DeleteCurrencyCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private CurrencyRepositoryInterface $repository,
    ) {
    }

    public function __invoke(DeleteCurrencyCommand $command): void
    {
        /** @var ?Currency $currency */
        $currency = $this->repository->findById($command->currencyId);
        if (null === $currency) {
            throw EntityNotFoundException::for(Currency::class, $command->currencyId);
        }

        $this->repository->remove($currency);
    }
}
