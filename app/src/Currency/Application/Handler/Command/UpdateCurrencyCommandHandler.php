<?php

declare(strict_types=1);

namespace App\Currency\Application\Handler\Command;

use App\Currency\Application\Command\UpdateCurrencyCommand;
use App\Currency\Application\Hydrator\CurrencyHydrator;
use App\Currency\Domain\Repository\CurrencyRepositoryInterface;
use App\Shared\Application\Command\CommandHandlerInterface;
use App\Shared\Application\DTO\Response\IdResponse;

final readonly class UpdateCurrencyCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private CurrencyHydrator $hydrator,
        private CurrencyRepositoryInterface $repository
    ) {
    }

    public function __invoke(UpdateCurrencyCommand $command): IdResponse
    {
       $currency = $this->hydrator->hydrate($command->data, $command->currency);

       $this->repository->save($currency);

       return new IdResponse($currency->getId());
    }
}
