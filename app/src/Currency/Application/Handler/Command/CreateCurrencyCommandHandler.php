<?php

declare(strict_types=1);

namespace App\Currency\Application\Handler\Command;

use App\Common\Application\Command\Interfaces\CommandHandlerInterface;
use App\Common\Application\Dto\Response\IdResponse;
use App\Currency\Application\Command\CreateCurrencyCommand;
use App\Currency\Application\Hydrator\CurrencyHydrator;
use App\Currency\Domain\Repository\CurrencyRepositoryInterface;

final readonly class CreateCurrencyCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private CurrencyHydrator $hydrator,
        private CurrencyRepositoryInterface $repository
    ) {

    }

    public function __invoke(CreateCurrencyCommand $command): IdResponse
    {
        $currency = $this->hydrator->hydrate($command->data);

        $this->repository->save($currency);

        return new IdResponse($currency->getId());
    }
}
