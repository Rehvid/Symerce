<?php

declare(strict_types=1);

namespace App\Currency\Application\Handler\Command;

use App\Common\Application\Command\Interfaces\CommandHandlerInterface;
use App\Common\Application\Dto\Response\IdResponse;
use App\Common\Domain\Entity\Currency;
use App\Common\Domain\Exception\EntityNotFoundException;
use App\Currency\Application\Command\UpdateCurrencyCommand;
use App\Currency\Application\Hydrator\CurrencyHydrator;
use App\Currency\Domain\Repository\CurrencyRepositoryInterface;

final readonly class UpdateCurrencyCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private CurrencyHydrator $hydrator,
        private CurrencyRepositoryInterface $repository
    ) {
    }

    public function __invoke(UpdateCurrencyCommand $command): IdResponse
    {
        /** @var ?Currency $currency */
        $currency = $this->repository->findById($command->currencyId);
        if (null === $currency) {
            throw EntityNotFoundException::for(Currency::class, $command->currencyId);
        }

        $currency = $this->hydrator->hydrate($command->data, $currency);

        $this->repository->save($currency);

        return new IdResponse($currency->getId());
    }
}
